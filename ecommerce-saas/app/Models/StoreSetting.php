<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'store_name',
        'business_category',
        'tagline',
        'logo_url',
        'contact_email',
        'primary_color',
        'secondary_color',
        'font_family',
        'banner_url',
        'hero_title',
        'hero_subtitle',
        'hero_button_text',
        'show_announcement',
        'announcement_text',
        'whatsapp_number',
        'instagram_url',
        'facebook_url',
        'official_website_url',
        'address',
        'neighborhood_zone',
        'city',
        'latitude',
        'longitude',
        'maps_url',
        'opening_hours',
        'location_reference',
        'footer_text',
    ];

    protected $casts = [
        'show_announcement' => 'boolean',
    ];
}
