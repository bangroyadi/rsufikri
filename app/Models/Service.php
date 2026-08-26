<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Service extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'icon',
        'image',
        'gallery',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'name' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get all gallery images formatted as full URLs.
     */
    public function getGalleryImagesAttribute(): array
    {
        // 1. If admin has customized gallery, respect it directly
        if (is_array($this->gallery)) {
            $formatted = [];
            foreach ($this->gallery as $item) {
                if (empty($item)) continue;
                if (str_starts_with($item, 'http://') || str_starts_with($item, 'https://')) {
                    $formatted[] = $item;
                } else {
                    $path = ltrim($item, '/');
                    if (str_starts_with($path, 'storage/')) {
                        $path = substr($path, 8);
                    }
                    $formatted[] = asset('storage/' . $path);
                }
            }
            return array_values($formatted);
        }

        // 2. Otherwise return defaults based on service
        return $this->default_gallery_images;
    }

    /**
     * Get default promotional gallery images
     */
    public function getDefaultGalleryImagesAttribute(): array
    {
        $defaults = [];

        // If main service image exists, include it first
        if (!empty($this->image)) {
            $img = $this->image;
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                $defaults[] = $img;
            } else {
                $defaults[] = asset($img);
            }
        }

        // Add service-specific promotional fallback images
        $slug = $this->slug ?? '';
        if (str_contains($slug, 'kemilau-cinta') || str_contains($slug, 'ibu-anak')) {
            $defaults[] = asset('gedung1_web.jpg');
            $defaults[] = asset('banner-igd.png');
        } elseif (str_contains($slug, 'trauma-center') || str_contains($slug, 'bedah')) {
            $defaults[] = asset('trauma-center.png');
            $defaults[] = asset('gedung2_web.jpg');
        } elseif (str_contains($slug, 'mata')) {
            $defaults[] = asset('spesialis-mata.png');
            $defaults[] = asset('gedung1_web.jpg');
        } else {
            $defaults[] = asset('gedung1_web.jpg');
            $defaults[] = asset('banner-igd.png');
        }

        return array_values(array_unique($defaults));
    }
}
