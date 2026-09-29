<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price',
        'stock', 'image_url', 'image_data', 'is_active',
        'is_service', 'duration_minutes',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_service' => 'boolean',
            'duration_minutes' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            $val = $product->attributes['image_url'] ?? null;
            if (!empty($val) && !str_starts_with($val, 'http://') && !str_starts_with($val, 'https://') && !str_starts_with($val, '//') && !str_starts_with($val, 'data:')) {
                $possiblePaths = [
                    storage_path('app/public/' . ltrim($val, '/')),
                    public_path('storage/' . ltrim($val, '/')),
                ];
                foreach ($possiblePaths as $p) {
                    if (file_exists($p) && is_file($p)) {
                        $mime = mime_content_type($p) ?: 'image/jpeg';
                        $data = file_get_contents($p);
                        if ($data !== false && strlen($data) > 0 && strlen($data) <= 15000000) {
                            $product->image_data = 'data:' . $mime . ';base64,' . base64_encode($data);
                            break;
                        }
                    }
                }
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function staff(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Staff::class, 'staff_service', 'product_id', 'staff_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'product_id');
    }

    public function scopeServices($query)
    {
        return $query->where('is_service', true);
    }

    public function scopeGoods($query)
    {
        return $query->where('is_service', false);
    }

    public function getImageUrlAttribute(?string $value): ?string
    {
        if (blank($value)) {
            return !empty($this->attributes['image_data']) ? $this->attributes['image_data'] : null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '//') || str_starts_with($value, 'data:')) {
            return $value;
        }

        // If local file exists (or is faked in tests), serve via asset URL
        $path = storage_path('app/public/' . ltrim($value, '/'));
        if (file_exists($path) || \Illuminate\Support\Facades\Storage::disk('public')->exists(ltrim($value, '/'))) {
            return asset('storage/' . ltrim($value, '/'));
        }

        // If local file is missing (e.g. after container redeploy), fallback to persisted base64 image data
        if (!empty($this->attributes['image_data'])) {
            return $this->attributes['image_data'];
        }

        return asset('storage/' . ltrim($value, '/'));
    }
}
