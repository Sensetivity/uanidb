<?php

namespace App\Models\Builders;

use App\Models\Person;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Person>
 */
class PersonBuilder extends Builder
{
    public function search(string $search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }
}
