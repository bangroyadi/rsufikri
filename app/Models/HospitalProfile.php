<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class HospitalProfile extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'logo',
        'address',
        'phone',
        'whatsapp',
        'email',
        'emergency_phone',
        'maps_embed',
        'operating_hours',
        'social_links',
        'about',
        'vision',
        'mission',
        'values',
    ];

    protected $casts = [
        'social_links' => 'array',
        'about' => 'array',
        'vision' => 'array',
        'mission' => 'array',
        'values' => 'array',
    ];
}
