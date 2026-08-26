<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Carbon\Carbon;

class HospitalEvent extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'speakers',
        'quota',
        'price_type',
        'price',
        'benefits',
        'image',
        'short_description',
        'description',
        'registration_link',
        'whatsapp_contact',
        'status',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'title' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'speakers' => 'array',
        'benefits' => 'array',
        'event_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
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
     * Human-readable formatted date (e.g. "Sabtu, 15 Agustus 2026")
     */
    public function getEventDateFormattedAttribute(): string
    {
        if (!$this->event_date) {
            return 'Segera Diumumkan';
        }
        return $this->event_date->translatedFormat('l, d F Y');
    }

    /**
     * Short day & month badge (e.g. "15 AGS")
     */
    public function getEventDateShortAttribute(): array
    {
        if (!$this->event_date) {
            return ['day' => '--', 'month' => 'TBA', 'year' => ''];
        }
        return [
            'day' => $this->event_date->format('d'),
            'month' => strtoupper($this->event_date->translatedFormat('M')),
            'year' => $this->event_date->format('Y'),
        ];
    }

    /**
     * Status Label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Telah Selesai',
            default => 'Akan Datang',
        };
    }
}
