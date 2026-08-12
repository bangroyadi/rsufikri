<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'button_text',
        'button_link',
        'order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'button_text' => 'array',
        'is_active' => 'boolean',
    ];

    public function getImageAttribute($value)
    {
        if (!$value) {
            return null;
        }

        if (Str::contains($value, '/storage/')) {
            $path = Str::after($value, '/storage/');
            return asset('storage/' . ltrim($path, '/'));
        }

        if (Str::startsWith($value, 'storage/')) {
            return asset($value);
        }

        if (Str::startsWith($value, 'http://') || Str::startsWith($value, 'https://')) {
            return $value;
        }

        return asset($value);
    }
}
