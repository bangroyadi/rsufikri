<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

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

    public function polyclinic()
    {
        return $this->belongsTo(Polyclinic::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
