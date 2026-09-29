<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerMembershipLog extends Model
{
    protected $fillable = [
        'customer_membership_id',
        'type',
        'points_delta',
        'description',
        'performed_at',
    ];

    protected function casts(): array
    {
        return [
            'points_delta' => 'integer',
            'performed_at' => 'datetime',
        ];
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(CustomerMembership::class, 'customer_membership_id');
    }
}
