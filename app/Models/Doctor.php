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
        'title_degree',
        'polyclinic_id',
        'specialty',
        'photo',
        'bio',
        'is_active',
    ];

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
}
