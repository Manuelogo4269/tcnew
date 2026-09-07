<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'logo_url',
        'primary_color',
        'banner_url',
        'store_name',
        'contact_email',
    ];
}
