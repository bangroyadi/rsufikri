<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Polyclinic extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'gallery',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'gallery' => 'array',
        'is_active' => 'boolean',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function getRouteUrlAttribute(): string
    {
        return url('/dokter/' . $this->slug . '-karawang');
    }

    /**
     * Get formatted gallery image URLs for this polyclinic.
     */
    public function getGalleryImagesAttribute(): array
    {
        $gallery = $this->gallery;
        if (is_string($gallery)) {
            $gallery = json_decode($gallery, true);
        }

        // If gallery has been modified by admin (is an array)
        if (is_array($gallery)) {
            $formatted = [];
            foreach ($gallery as $img) {
                if (empty($img)) continue;
                if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://') || str_starts_with($img, '/')) {
                    $formatted[] = $img;
                } else {
                    $formatted[] = asset('storage/' . $img);
                }
            }
            // If admin set gallery (even if empty after deleting all photos), return formatted
            return array_values($formatted);
        }

        if (!empty($this->image)) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '/')) {
                return [$this->image];
            }
            return [asset('storage/' . $this->image)];
        }

        // Only fallback to defaults if gallery has never been modified (null)
        return $this->getDefaultGalleryImages();
    }

    /**
     * Default representative clinic images based on specialty.
     */
    public function getDefaultGalleryImages(): array
    {
        $slug = $this->slug ?? '';
        if (in_array($slug, ['bedah', 'orthopedi', 'bedah-saraf', 'bedah-mulut'])) {
            return [asset('trauma-center.png'), asset('gedung2_web.jpg')];
        }
        if ($slug === 'mata') {
            return [asset('spesialis-mata.png'), asset('gedung1_web.jpg')];
        }
        return [asset('gedung1_web.jpg'), asset('banner-igd.png')];
    }
}
