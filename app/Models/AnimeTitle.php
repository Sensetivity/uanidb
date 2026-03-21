<?php

namespace App\Models;

use App\Enums\AnimeTitleTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $anime_id
 * @property string $title
 * @property string $language ISO language code (e.g., 'en', 'ja', 'uk')
 * @property AnimeTitleTypeEnum $source
 *@property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Anime $anime
 */
class AnimeTitle extends Model
{
    /** @use HasFactory<\Illuminate\Database\Eloquent\Factories\Factory<self>> */
    use HasFactory;

    protected $guarded = ['id'];

    /** @return BelongsTo<Anime, $this> */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'anime_id' => 'integer',
            'source'   => AnimeTitleTypeEnum::class,
        ];
    }
}
