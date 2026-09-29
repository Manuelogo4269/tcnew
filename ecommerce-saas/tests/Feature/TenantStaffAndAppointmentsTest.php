<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Product;
use App\Models\Staff;
use App\Models\Tenant;
use Tests\TestCase;

class TenantStaffAndAppointmentsTest extends TestCase
{
    protected string $tenantId = 'conceptos7';

    protected function setUp(): void
    {
        parent::setUp();

        $tenant = Tenant::findOrFail($this->tenantId);
        $tenant->run(function () {
            Appointment::query()->delete();

            $cat = \App\Models\Category::firstOrCreate(
                ['slug' => 'servicios-profesionales'],
                ['name' => 'Servicios Profesionales']
            );

            // Seed a service product
            $service = Product::updateOrCreate(
                ['slug' => 'corte-y-estilo-vip'],
                [
                    'category_id' => $cat->id,
                    'name' => 'Corte & Estilo VIP',
                    'price' => 350.00,
                    'stock' => 999,
                    'is_active' => true,
                    'is_service' => true,
                    'duration_minutes' => 45,
                    'description' => 'Servicio de corte, lavado y peinado profesional con asesoría de imagen.',
                ]
            );

            // Seed a specialist staff member
            $staff = Staff::updateOrCreate(
                ['email' => 'carlos.estilista@conceptos7.com'],
                [
                    'name' => 'Carlos Mendoza',
                    'role' => 'Master Stylist & Barbero',
                    'phone' => '4921002030',
                    'photo_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                    'is_active' => true,
                ]
            );

            // Associate service to staff
            $staff->services()->syncWithoutDetaching([$service->id]);
        });
    }

    public function test_api_lists_services_and_staff(): void
    {
        $resServices = $this->getJson("/api/tienda/{$this->tenantId}/services");
        $resServices->assertStatus(200)
            ->assertJsonFragment(['name' => 'Corte & Estilo VIP'])
            ->assertJsonFragment(['duration_minutes' => 45]);

        $resStaff = $this->getJson("/api/tienda/{$this->tenantId}/staff");
        $resStaff->assertStatus(200)
            ->assertJsonFragment(['name' => 'Carlos Mendoza'])
            ->assertJsonFragment(['role' => 'Master Stylist & Barbero']);
    }

    public function test_api_calculates_available_time_slots(): void
    {
        $tenant = Tenant::findOrFail($this->tenantId);
        $staffId = $tenant->run(fn () => Staff::where('is_active', true)->first()->id);
        $serviceId = $tenant->run(fn () => Product::where('is_service', true)->first()->id);

        $tomorrow = now()->addDay()->format('Y-m-d');

        $response = $this->getJson("/api/tienda/{$this->tenantId}/appointments/available-slots?date={$tomorrow}&staff_id={$staffId}&service_id={$serviceId}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'date',
                'duration_minutes',
                'slots' => [
                    '*' => ['time', 'label', 'datetime']
                ]
            ]);

        $this->assertNotEmpty($response->json('slots'));
    }

    public function test_customer_can_book_appointment_and_prevents_overlap(): void
    {
        $tenant = Tenant::findOrFail($this->tenantId);
        $staff = $tenant->run(fn () => Staff::first());
        $service = $tenant->run(fn () => Product::where('is_service', true)->first());

        $bookingDate = now()->addDays(2)->format('Y-m-d') . ' 11:00:00';

        // 1. First booking succeeds
        $res1 = $this->postJson("/api/tienda/{$this->tenantId}/appointments", [
            'customer_name' => 'Alejandro Ramos',
            'customer_phone' => '4929876543',
            'customer_email' => 'alejandro@example.com',
            'staff_id' => $staff->id,
            'service_id' => $service->id,
            'scheduled_at' => $bookingDate,
            'notes' => 'Primera cita, asesoría de imagen',
        ]);

        $res1->assertStatus(201)
            ->assertJson(['success' => true])
            ->assertJsonPath('appointment.customer_name', 'Alejandro Ramos')
            ->assertJsonPath('appointment.status', 'confirmed');

        // 2. Second booking on identical slot for the same staff is prevented
        $res2 = $this->postJson("/api/tienda/{$this->tenantId}/appointments", [
            'customer_name' => 'Roberto Gómez',
            'customer_phone' => '4921112233',
            'staff_id' => $staff->id,
            'service_id' => $service->id,
            'scheduled_at' => $bookingDate,
        ]);

        $res2->assertStatus(422)
            ->assertJsonValidationErrors(['scheduled_at']);
    }

    public function test_customer_can_view_their_appointments(): void
    {
        $tenant = Tenant::findOrFail($this->tenantId);
        $staff = $tenant->run(fn () => Staff::first());

        $tenant->run(function () use ($staff) {
            Appointment::create([
                'customer_name' => 'Mariana Torres',
                'customer_phone' => '4925556677',
                'customer_email' => 'mariana.citas@example.com',
                'staff_id' => $staff->id,
                'service_name' => 'Manicura Spa Rusa',
                'scheduled_at' => now()->addDays(3)->setTime(15, 0),
                'end_at' => now()->addDays(3)->setTime(15, 45),
                'duration_minutes' => 45,
                'price' => 280.00,
                'status' => 'confirmed',
            ]);
        });

        $res = $this->getJson("/api/tienda/{$this->tenantId}/appointments/my-appointments?email=mariana.citas@example.com");
        $res->assertStatus(200)
            ->assertJsonFragment(['customer_name' => 'Mariana Torres'])
            ->assertJsonFragment(['service_name' => 'Manicura Spa Rusa']);
    }

    public function test_appointment_statuses_can_be_transitioned(): void
    {
        $tenant = Tenant::findOrFail($this->tenantId);
        $staff = $tenant->run(fn () => Staff::first());

        $apptId = $tenant->run(function () use ($staff) {
            $a = Appointment::create([
                'customer_name' => 'Sofia Morales',
                'customer_phone' => '4923334455',
                'staff_id' => $staff->id,
                'service_name' => 'Facial Hidratante',
                'scheduled_at' => now()->addHours(1),
                'end_at' => now()->addHours(2),
                'duration_minutes' => 60,
                'price' => 450.00,
                'status' => Appointment::STATUS_CONFIRMED,
            ]);
            return $a->id;
        });

        // Transition: confirmed -> in_service -> completed
        $tenant->run(function () use ($apptId) {
            $appt = Appointment::findOrFail($apptId);
            $appt->update(['status' => Appointment::STATUS_IN_SERVICE]);
            $this->assertEquals(Appointment::STATUS_IN_SERVICE, $appt->fresh()->status);

            $appt->update(['status' => Appointment::STATUS_COMPLETED]);
            $this->assertEquals(Appointment::STATUS_COMPLETED, $appt->fresh()->status);
        });
    }
}
