<?php

namespace App\Models;

use App\Enums\PromotionVideoTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionVideo extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
        'duration' => 'integer',
        'is_main' => 'boolean',
        'order' => 'integer',
        'type' => PromotionVideoTypeEnum::class,
    ];

    /**
     * Get the anime that owns the promotion video.
     */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    /**
     * Extract YouTube ID from URL if needed.
     *
     * @param string $url
     * @return string|null
     */
    public static function extractYouTubeId($url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get the YouTube embed URL.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        return $this->video_id ? "https://www.youtube.com/embed/{$this->video_id}" : null;
    }

    /**
     * Get the YouTube thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->video_id ? "https://img.youtube.com/vi/{$this->video_id}/hqdefault.jpg" : null;
    }

    /**
     * Handle setting video_id from video_url.
     */
    protected static function booted()
    {
        static::creating(function ($promotionVideo) {
            if (!$promotionVideo->video_id && $promotionVideo->video_url) {
                $promotionVideo->video_id = self::extractYouTubeId($promotionVideo->video_url);
            }
        });

        static::updating(function ($promotionVideo) {
            if ($promotionVideo->isDirty('video_url')) {
                $promotionVideo->video_id = self::extractYouTubeId($promotionVideo->video_url);
            }
        });
    }
}
