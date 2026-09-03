<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'title_degree',
        'polyclinic_id',
        'specialty',
        'photo',
        'bio',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($doctor) {
            if (empty($doctor->slug)) {
                $baseSlug = Str::slug($doctor->name . ($doctor->title_degree ? ' ' . $doctor->title_degree : ''));
                if (empty($baseSlug)) {
                    $baseSlug = 'dokter-' . time();
                }
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->where('id', '!=', $doctor->id ?? 0)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }
                $doctor->slug = $slug;
            }
        });
    }

    protected $casts = [
        'specialty' => 'array',
        'bio' => 'array',
        'is_active' => 'boolean',
    ];

    public function getPhotoAttribute($value)
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

        if (Str::startsWith($value, 'doctors/')) {
            return asset('storage/' . $value);
        }

        return $value;
    }

    public function polyclinic()
    {
        return $this->belongsTo(Polyclinic::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_doctor')->withTimestamps();
    }

    public function getRouteUrlAttribute(): string
    {
        $slug = $this->slug ?: Str::slug($this->name . ($this->title_degree ? ' ' . $this->title_degree : ''));
        return url('/dokter/' . $slug);
    }

    public function getFullNameAttribute(): string
    {
        if (empty($this->title_degree)) {
            return $this->name;
        }

        $cleanDegree = trim(trim($this->title_degree), ',');
        if (Str::contains($this->name, $cleanDegree)) {
            return $this->name;
        }

        return $this->name . ', ' . $cleanDegree;
    }

    public function getSpecialtyNameAttribute(): string
    {
        $spec = $this->tr('specialty');
        if (!empty($spec)) {
            return $spec;
        }
        return $this->polyclinic?->tr('name') ?: 'Dokter Spesialis';
    }
}
