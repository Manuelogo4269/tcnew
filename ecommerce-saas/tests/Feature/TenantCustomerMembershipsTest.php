<?php

namespace Tests\Feature;

use App\Models\CustomerMembership;
use App\Models\MembershipPlan;
use App\Models\Tenant;
use Tests\TestCase;

class TenantCustomerMembershipsTest extends TestCase
{
    protected string $tenantId = 'conceptos7';

    protected function setUp(): void
    {
        parent::setUp();

        $tenant = Tenant::findOrFail($this->tenantId);
        $tenant->run(function () {
            CustomerMembership::query()->delete();

            // Seed a membership plan
            MembershipPlan::updateOrCreate(
                ['slug' => 'pase-vip-black'],
                [
                    'name' => 'Pase VIP Black',
                    'price' => 799.00,
                    'duration_days' => 30,
                    'visits_included' => 8,
                    'points_multiplier' => 1.50,
                    'perks_json' => [
                        '20% de descuento en todos los servicios de corte',
                        'Bebida de cortesía en cada visita',
                        'Prioridad de reserva en fines de semana',
                    ],
                    'badge_color' => '#f59e0b',
                    'is_active' => true,
                ]
            );
        });
    }

    public function test_api_lists_active_membership_plans(): void
    {
        $response = $this->getJson("/api/tienda/{$this->tenantId}/memberships/plans");
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Pase VIP Black'])
            ->assertJsonFragment(['duration_days' => 30])
            ->assertJsonFragment(['visits_included' => 8]);
    }

    public function test_customer_membership_card_generation_and_lookup(): void
    {
        $tenant = Tenant::findOrFail($this->tenantId);
        $plan = $tenant->run(fn () => MembershipPlan::where('slug', 'pase-vip-black')->first());

        $membershipCode = $tenant->run(function () use ($plan) {
            $membership = CustomerMembership::create([
                'customer_name' => 'Valeria Castillo',
                'customer_email' => 'valeria.socio@example.com',
                'customer_phone' => '4928889900',
                'membership_plan_id' => $plan->id,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(30)->toDateString(),
                'status' => 'active',
                'visits_used' => 2,
                'accumulated_points' => 350,
            ]);

            return $membership->membership_code;
        });

        $this->assertNotEmpty($membershipCode);
        $this->assertStringStartsWith('MEM-', $membershipCode);

        // Lookup by email
        $resEmail = $this->getJson("/api/tienda/{$this->tenantId}/memberships/my-card?email=valeria.socio@example.com");
        $resEmail->assertStatus(200)
            ->assertJson(['has_membership' => true])
            ->assertJsonPath('membership.customer_name', 'Valeria Castillo')
            ->assertJsonPath('membership.plan_name', 'Pase VIP Black')
            ->assertJsonPath('membership.code', $membershipCode)
            ->assertJsonPath('membership.visits_used', 2)
            ->assertJsonPath('membership.accumulated_points', 350);

        // Lookup by unique membership code
        $resCode = $this->getJson("/api/tienda/{$this->tenantId}/memberships/my-card?code={$membershipCode}");
        $resCode->assertStatus(200)
            ->assertJson(['has_membership' => true])
            ->assertJsonPath('membership.customer_name', 'Valeria Castillo');
    }

    public function test_recording_member_visit_updates_visits_and_points_log(): void
    {
        $tenant = Tenant::findOrFail($this->tenantId);
        $plan = $tenant->run(fn () => MembershipPlan::where('slug', 'pase-vip-black')->first());

        $tenant->run(function () use ($plan) {
            $membership = CustomerMembership::create([
                'customer_name' => 'Eduardo Neri',
                'customer_email' => 'eduardo@example.com',
                'membership_plan_id' => $plan->id,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(30)->toDateString(),
                'status' => 'active',
                'visits_used' => 0,
                'accumulated_points' => 0,
            ]);

            // Record a visit
            $membership->recordVisit('Corte de cabello y barba en sucursal');

            $fresh = $membership->fresh();
            $this->assertEquals(1, $fresh->visits_used);
            $this->assertGreaterThan(0, $fresh->accumulated_points);
            $this->assertEquals(1, $fresh->logs()->count());
            $this->assertEquals('visit', $fresh->logs()->first()->type);
        });
    }
}
