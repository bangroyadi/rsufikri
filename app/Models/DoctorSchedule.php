<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class DoctorSchedule extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'doctor_id',
        'polyclinic_id',
        'day',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'notes' => 'array',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function polyclinic()
    {
        return $this->belongsTo(Polyclinic::class);
    }
}
