<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id',
        'full_name',
        'email',
        'phone',
        'last_education',
        'experience_years',
        'str_number',
        'cv_file',
        'portfolio_url',
        'cover_letter',
        'status',
        'hrd_notes',
    ];

    /**
     * Relationship to Career Vacancy
     */
    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id');
    }

    /**
     * Formatted CV File URL
     */
    public function getCvFileUrlAttribute(): string
    {
        if (empty($this->cv_file)) {
            return '';
        }
        if (str_starts_with($this->cv_file, 'http://') || str_starts_with($this->cv_file, 'https://')) {
            return $this->cv_file;
        }
        $path = ltrim($this->cv_file, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        return asset('storage/' . $path);
    }

    /**
     * Status Label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'reviewed' => 'Sedang Direview',
            'interview' => 'Panggilan Interview',
            'accepted' => 'Diterima / Lolos',
            'rejected' => 'Tidak Lolos',
            default => 'Lamaran Masuk (Baru)',
        };
    }

    /**
     * Status Badge Style
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'reviewed' => ['bg' => 'bg-blue-50 text-blue-700 border-blue-200', 'icon' => 'fa-eye'],
            'interview' => ['bg' => 'bg-amber-50 text-amber-700 border-amber-200', 'icon' => 'fa-comments'],
            'accepted' => ['bg' => 'bg-emerald-50 text-[#0e7c47] border-emerald-200', 'icon' => 'fa-circle-check'],
            'rejected' => ['bg' => 'bg-red-50 text-red-700 border-red-200', 'icon' => 'fa-circle-xmark'],
            default => ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'icon' => 'fa-inbox'],
        };
    }
}
