<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CustomerMembership extends Model
{
    protected $fillable = [
        'tenant_user_id',
        'customer_account_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'membership_plan_id',
        'membership_code',
        'start_date',
        'end_date',
        'status',
        'visits_used',
        'accumulated_points',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'visits_used' => 'integer',
            'accumulated_points' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (CustomerMembership $membership) {
            if (empty($membership->membership_code)) {
                $membership->membership_code = 'MEM-' . strtoupper(Str::random(6));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(TenantUser::class, 'tenant_user_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(CustomerMembershipLog::class);
    }

    public function isValid(): bool
    {
        return $this->status === 'active' && now()->startOfDay()->lte($this->end_date);
    }

    /**
     * Record a client visit and award points according to the plan.
     */
    public function recordVisit(string $description = 'Visita al establecimiento'): void
    {
        $this->increment('visits_used');

        $pointsMultiplier = (float) ($this->plan?->points_multiplier ?? 1.0);
        $pointsEarned = (int) round(10 * $pointsMultiplier);

        $this->increment('accumulated_points', $pointsEarned);

        $this->logs()->create([
            'type' => 'visit',
            'points_delta' => $pointsEarned,
            'description' => $description,
            'performed_at' => now(),
        ]);
    }
}
