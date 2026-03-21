<?php

namespace App\Models\Builders;

use App\Models\Studio;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Studio>
 */
class StudioBuilder extends Builder
{
    public function search(string $search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }
}
