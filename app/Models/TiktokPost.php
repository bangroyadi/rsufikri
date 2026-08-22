<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiktokPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'views_count',
        'tag',
        'thumbnail',
        'video_url',
        'tiktok_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get extracted TikTok numeric Video ID
     */
    public function getVideoIdAttribute(): string
    {
        if (!empty($this->tiktok_url)) {
            if (preg_match('/\/video\/(\d+)/', $this->tiktok_url, $matches)) {
                return $matches[1];
            }
            if (preg_match('/player\/v1\/(\d+)/', $this->tiktok_url, $matches)) {
                return $matches[1];
            }
            if (preg_match('/embed\/v2\/(\d+)/', $this->tiktok_url, $matches)) {
                return $matches[1];
            }
            if (preg_match('/(\d{15,25})/', $this->tiktok_url, $matches)) {
                return $matches[1];
            }
        }
        return '7676297240599678216';
    }

    /**
     * Official TikTok Embedded Player v1 URL
     */
    public function getTiktokPlayerUrlAttribute(): string
    {
        return 'https://www.tiktok.com/player/v1/' . $this->video_id;
    }

    /**
     * Standard Embed URL
     */
    public function getTiktokEmbedUrlAttribute(): string
    {
        return 'https://www.tiktok.com/player/v1/' . $this->video_id;
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (!$this->thumbnail) {
            return asset('gedung1_web.jpg');
        }
        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }
        return asset('storage/' . $this->thumbnail);
    }
}
