<?php

namespace App\Models;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property ImportJobTypeEnum $job_type
 * @property int|null $anime_id
 * @property int|null $mal_id
 * @property ImportStatusEnum $status
 * @property Carbon|null $started_at
 * @property Carbon|null $completed_at
 * @property string|null $error_message
 * @property array|null $metadata
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class ImportLog extends Model
{
    /** @use HasFactory<\Database\Factories\ImportLogFactory> */
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'job_type' => ImportJobTypeEnum::class,
        'status' => ImportStatusEnum::class,
        'metadata' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = ['id'];

    /**
     * Get the anime associated with this import log.
     */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    /**
     * Mark the import log as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => ImportStatusEnum::Completed,
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark the import log as failed.
     */
    public function markAsFailed(string $error): void
    {
        $this->update([
            'status' => ImportStatusEnum::Failed,
            'completed_at' => now(),
            'error_message' => $error,
        ]);
    }

    /**
     * Mark the import log as running.
     */
    public function markAsRunning(): void
    {
        $this->update([
            'status' => ImportStatusEnum::Running,
            'started_at' => now(),
        ]);
    }

    /**
     * Get the user who initiated this import.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
