<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'badge',
        'original_price',
        'promo_price',
        'discount_percentage',
        'image',
        'short_description',
        'description',
        'features',
        'terms_conditions',
        'valid_until',
        'whatsapp_number',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'title' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'features' => 'array',
        'terms_conditions' => 'array',
        'valid_until' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'discount_percentage' => 'integer',
    ];

    /**
     * Formatted image URL
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('gedung1_web.jpg');
        }
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        $path = ltrim($this->image, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        return asset('storage/' . $path);
    }

    /**
     * Check if promo is still valid
     */
    public function getIsValidAttribute(): bool
    {
        if (!$this->is_active) {
            return false;
        }
        if ($this->valid_until) {
            return $this->valid_until->endOfDay()->isFuture();
        }
        return true;
    }

    /**
     * Format human readable valid date string
     */
    public function getValidUntilFormattedAttribute(): ?string
    {
        if (!$this->valid_until) {
            return 'Berlaku Selama Kuota Tersedia';
        }
        return $this->valid_until->translatedFormat('d F Y');
    }
}
