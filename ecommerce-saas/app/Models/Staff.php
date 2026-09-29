<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'name',
        'role',
        'email',
        'phone',
        'bio',
        'photo_url',
        'schedule_json',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'schedule_json' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'staff_service', 'staff_id', 'product_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
