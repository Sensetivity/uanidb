<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $anime_id
 * @property string $name
 * @property string $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Anime $anime
 */
class AnimeExternalLink extends Model
{
    protected $guarded = ['id'];

    /** @return BelongsTo<Anime, $this> */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }
}
