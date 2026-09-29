<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CustomerMembership;
use App\Models\MembershipPlan;
use App\Models\Product;
use App\Models\PushSubscription;
use App\Models\Staff;
use App\Models\Tenant;
use App\Models\TenantUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    /**
     * List all available services for appointment booking.
     */
    public function services(string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () {
            $services = Product::where('is_service', true)
                ->where('is_active', true)
                ->with('staff:id,name,role,photo_url')
                ->get()
                ->map(fn ($s) => [
                    'id' => $s->id,
                    'name' => $s->name,
                    'slug' => $s->slug,
                    'description' => $s->description,
                    'price' => (float) $s->price,
                    'duration_minutes' => $s->duration_minutes ?: 30,
                    'image_url' => $s->image_url,
                    'staff' => $s->staff,
                ]);

            return response()->json($services);
        });
    }

    /**
     * List active staff / specialists.
     */
    public function staff(string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () {
            $staff = Staff::where('is_active', true)
                ->with('services:id,name,duration_minutes,price')
                ->get()
                ->map(fn ($st) => [
                    'id' => $st->id,
                    'name' => $st->name,
                    'role' => $st->role,
                    'phone' => $st->phone,
                    'photo_url' => $st->photo_url,
                    'bio' => $st->bio,
                    'services' => $st->services->pluck('name'),
                ]);

            return response()->json($staff);
        });
    }

    /**
     * Calculate available booking time slots for a given date, staff, and service duration.
     */
    public function availableSlots(Request $request, string $tenant)
    {
        $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
            'staff_id' => ['nullable', 'integer'],
            'service_id' => ['nullable', 'integer'],
        ]);

        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($request) {
            $date = $request->input('date');
            $staffId = $request->input('staff_id');
            $serviceId = $request->input('service_id');

            $duration = 30;
            if ($serviceId) {
                $service = Product::find($serviceId);
                if ($service && $service->duration_minutes) {
                    $duration = (int) $service->duration_minutes;
                }
            }

            // Existing appointments on the requested date that are not cancelled
            $query = Appointment::whereDate('scheduled_at', $date)
                ->where('status', '!=', Appointment::STATUS_CANCELLED);

            if ($staffId) {
                $query->where('staff_id', $staffId);
            }

            $bookedAppointments = $query->get(['scheduled_at', 'end_at', 'staff_id']);

            // Business operating hours: 09:00 to 19:00
            $startHour = Carbon::parse("{$date} 09:00:00");
            $endHour = Carbon::parse("{$date} 19:00:00");

            $availableSlots = [];
            $slotCursor = $startHour->copy();

            while ($slotCursor->copy()->addMinutes($duration)->lte($endHour)) {
                $slotEnd = $slotCursor->copy()->addMinutes($duration);

                // Check conflict
                $isConflict = false;
                foreach ($bookedAppointments as $appt) {
                    $apptStart = Carbon::parse($appt->scheduled_at);
                    $apptEnd = Carbon::parse($appt->end_at);

                    // If times overlap
                    if ($slotCursor->lt($apptEnd) && $slotEnd->gt($apptStart)) {
                        $isConflict = true;
                        break;
                    }
                }

                if (!$isConflict) {
                    $availableSlots[] = [
                        'time' => $slotCursor->format('H:i'),
                        'label' => $slotCursor->format('g:i A'),
                        'datetime' => $slotCursor->toDateTimeString(),
                    ];
                }

                $slotCursor->addMinutes(30); // 30 min intervals
            }

            return response()->json([
                'date' => $date,
                'duration_minutes' => $duration,
                'slots' => $availableSlots,
            ]);
        });
    }

    /**
     * Book a new appointment in real-time.
     */
    public function book(Request $request, string $tenant)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:120'],
            'staff_id' => ['required', 'integer'],
            'service_id' => ['nullable', 'integer'],
            'service_name' => ['nullable', 'string', 'max:150'],
            'scheduled_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($validated, $request) {
            $staff = Staff::where('is_active', true)->findOrFail($validated['staff_id']);

            $service = null;
            $duration = 30;
            $price = 0.00;
            $serviceName = $validated['service_name'] ?? 'Servicio Profesional';

            if (!empty($validated['service_id'])) {
                $service = Product::find($validated['service_id']);
                if ($service) {
                    $serviceName = $service->name;
                    $duration = $service->duration_minutes ?: 30;
                    $price = (float) $service->price;
                }
            }

            $scheduledAt = Carbon::parse($validated['scheduled_at']);
            $endAt = $scheduledAt->copy()->addMinutes($duration);

            // Verify no double booking for this specialist
            $hasConflict = Appointment::where('staff_id', $staff->id)
                ->where('status', '!=', Appointment::STATUS_CANCELLED)
                ->where(function ($q) use ($scheduledAt, $endAt) {
                    $q->whereBetween('scheduled_at', [$scheduledAt, $endAt->copy()->subSecond()])
                      ->orWhereBetween('end_at', [$scheduledAt->copy()->addSecond(), $endAt])
                      ->orWhere(function ($sub) use ($scheduledAt, $endAt) {
                          $sub->where('scheduled_at', '<=', $scheduledAt)
                              ->where('end_at', '>=', $endAt);
                      });
                })
                ->exists();

            if ($hasConflict) {
                throw ValidationException::withMessages([
                    'scheduled_at' => ["El especialista {$staff->name} ya tiene una cita reservada en este horario. Por favor selecciona otro horario."],
                ]);
            }

            // Link to authenticated user if available
            $userId = null;
            if ($request->user()) {
                $acc = $request->user();
                $tenantUser = TenantUser::firstOrCreate(
                    ['customer_account_id' => (string) $acc->id],
                    [
                        'name' => $acc->name,
                        'email' => $acc->email,
                        'password' => Str::random(64),
                    ]
                );
                $userId = $tenantUser->id;
            } elseif (Auth::guard('web')->check()) {
                $userId = Auth::guard('web')->id();
            }

            $appointment = Appointment::create([
                'user_id' => $userId,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_phone' => $validated['customer_phone'],
                'staff_id' => $staff->id,
                'product_id' => $service?->id,
                'service_name' => $serviceName,
                'scheduled_at' => $scheduledAt,
                'end_at' => $endAt,
                'duration_minutes' => $duration,
                'price' => $price,
                'status' => Appointment::STATUS_CONFIRMED,
                'notes' => $validated['notes'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Cita confirmada y agendada exitosamente!',
                'appointment' => $appointment->load('staff'),
            ], 201);
        });
    }

    /**
     * List appointments for the current customer.
     */
    public function myAppointments(Request $request, string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($request) {
            $user = $request->user();
            $query = Appointment::with('staff')->latest('scheduled_at');

            if ($user) {
                $tenantUser = TenantUser::where('customer_account_id', (string) $user->id)->first();
                if ($tenantUser) {
                    $query->where('user_id', $tenantUser->id);
                } else {
                    $query->where('customer_email', $user->email);
                }
            } elseif ($request->filled('email')) {
                $query->where('customer_email', $request->input('email'));
            } elseif ($request->filled('phone')) {
                $query->where('customer_phone', $request->input('phone'));
            } else {
                return response()->json(['data' => []]);
            }

            return response()->json($query->paginate(20));
        });
    }

    /**
     * List all membership plans for storefront & mobile.
     */
    public function membershipPlans(string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () {
            $plans = MembershipPlan::where('is_active', true)
                ->orderBy('price', 'asc')
                ->get()
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'description' => $p->description,
                    'price' => (float) $p->price,
                    'duration_days' => $p->duration_days,
                    'visits_included' => $p->visits_included,
                    'points_multiplier' => (float) $p->points_multiplier,
                    'perks' => $p->perks_json ?: [],
                    'badge_color' => $p->badge_color ?: '#d96b45',
                ]);

            return response()->json($plans);
        });
    }

    /**
     * Get digital membership card and loyalty points for the customer.
     */
    public function myMembership(Request $request, string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($request) {
            $user = $request->user();
            $query = CustomerMembership::with(['plan', 'logs' => fn ($q) => $q->latest()->take(10)]);

            if ($user) {
                $tenantUser = TenantUser::where('customer_account_id', (string) $user->id)->first();
                $query->where(function ($q) use ($tenantUser, $user) {
                    if ($tenantUser) {
                        $q->where('tenant_user_id', $tenantUser->id)
                          ->orWhere('customer_account_id', (string) $user->id)
                          ->orWhere('customer_email', $user->email);
                    } else {
                        $q->where('customer_account_id', (string) $user->id)
                          ->orWhere('customer_email', $user->email);
                    }
                });
            } elseif ($request->filled('code')) {
                $query->where('membership_code', strtoupper(trim($request->input('code'))));
            } elseif ($request->filled('email')) {
                $query->where('customer_email', trim($request->input('email')));
            } else {
                return response()->json([
                    'has_membership' => false,
                    'message' => 'Inicia sesión o ingresa tu correo para consultar tu membresía.',
                ]);
            }

            $membership = $query->latest()->first();

            if (!$membership) {
                return response()->json([
                    'has_membership' => false,
                    'message' => 'No se encontró ninguna membresía activa para estos datos.',
                ]);
            }

            return response()->json([
                'has_membership' => true,
                'membership' => [
                    'id' => $membership->id,
                    'code' => $membership->membership_code,
                    'customer_name' => $membership->customer_name,
                    'customer_email' => $membership->customer_email,
                    'plan_name' => $membership->plan?->name,
                    'badge_color' => $membership->plan?->badge_color ?? '#d96b45',
                    'start_date' => $membership->start_date->format('d/m/Y'),
                    'end_date' => $membership->end_date->format('d/m/Y'),
                    'is_valid' => $membership->isValid(),
                    'days_remaining' => max(0, now()->diffInDays($membership->end_date, false)),
                    'visits_used' => $membership->visits_used,
                    'visits_included' => $membership->plan?->visits_included ?? 0,
                    'accumulated_points' => $membership->accumulated_points,
                    'perks' => $membership->plan?->perks_json ?: [],
                    'recent_logs' => $membership->logs->map(fn ($l) => [
                        'type' => $l->type,
                        'points_delta' => $l->points_delta,
                        'description' => $l->description,
                        'date' => $l->performed_at->format('d/m/Y H:i'),
                    ]),
                ],
            ]);
        });
    }

    /**
     * Subscribe customer device to WebPush notifications.
     */
    public function subscribePush(Request $request, string $tenant)
    {
        $validated = $request->validate([
            'endpoint' => ['required', 'string'],
            'public_key' => ['nullable', 'string'],
            'auth_token' => ['nullable', 'string'],
            'user_identifier' => ['nullable', 'string'],
        ]);

        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($validated, $request) {
            $identifier = $validated['user_identifier'] ?? null;
            if (!$identifier && $request->user()) {
                $identifier = $request->user()->email;
            }

            $sub = PushSubscription::updateOrCreate(
                ['endpoint' => $validated['endpoint']],
                [
                    'user_identifier' => $identifier,
                    'public_key' => $validated['public_key'] ?? null,
                    'auth_token' => $validated['auth_token'] ?? null,
                    'user_agent' => $request->userAgent(),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Dispositivo suscrito a notificaciones exitosamente.',
                'subscription_id' => $sub->id,
            ]);
        });
    }

    /**
     * Send test push notification trigger.
     */
    public function sendTestPush(Request $request, string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($request) {
            $count = PushSubscription::count();

            return response()->json([
                'success' => true,
                'message' => "Notificación de prueba enviada a {$count} dispositivos registrados.",
                'subscribers_count' => $count,
                'payload' => [
                    'title' => '¡Atelier · Recordatorio de Cita!',
                    'body' => 'Tu cita ha sido confirmada. Te esperamos 10 minutos antes en Zacatecas Centro.',
                    'icon' => '/app-icons/icon-192.png',
                ],
            ]);
        });
    }
}
