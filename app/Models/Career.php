<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Carbon\Carbon;

class Career extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'department',
        'employment_type',
        'education_level',
        'experience_years',
        'location',
        'quota',
        'short_description',
        'description',
        'requirements',
        'responsibilities',
        'benefits',
        'deadline',
        'status',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'title' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'requirements' => 'array',
        'responsibilities' => 'array',
        'benefits' => 'array',
        'deadline' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Relationship to Job Applications
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'career_id')->orderBy('created_at', 'desc');
    }

    /**
     * Total Applications Count
     */
    public function getApplicationsCountAttribute(): int
    {
        return $this->applications()->count();
    }

    /**
     * Format Deadline (e.g. "30 September 2026")
     */
    public function getDeadlineFormattedAttribute(): string
    {
        if (!$this->deadline) {
            return 'Terbuka Hingga Terpenuhi';
        }
        return $this->deadline->translatedFormat('d F Y');
    }

    /**
     * Check if vacancy is still open (status == open and deadline in future or null)
     */
    public function getIsOpenAttribute(): bool
    {
        if ($this->status === 'closed') {
            return false;
        }
        if ($this->deadline && $this->deadline->isPast() && !$this->deadline->isToday()) {
            return false;
        }
        return true;
    }

    /**
     * Department Badge Theme Colors
     */
    public function getDepartmentBadgeAttribute(): array
    {
        return match($this->department) {
            'Medis' => ['bg' => 'bg-emerald-50', 'text' => 'text-[#0e7c47]', 'border' => 'border-emerald-200', 'icon' => 'fa-user-doctor'],
            'Keperawatan' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-700', 'border' => 'border-teal-200', 'icon' => 'fa-user-nurse'],
            'Farmasi' => ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-700', 'border' => 'border-cyan-200', 'icon' => 'fa-pills'],
            'Penunjang Medis' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'icon' => 'fa-microscope'],
            'Administrasi & IT' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'border' => 'border-sky-200', 'icon' => 'fa-laptop-medical'],
            default => ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'icon' => 'fa-briefcase'],
        };
    }
}
