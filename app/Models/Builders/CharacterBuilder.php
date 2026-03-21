<?php

namespace App\Models\Builders;

use App\Models\Character;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Character>
 */
class CharacterBuilder extends Builder
{
    public function search(string $search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }
}
