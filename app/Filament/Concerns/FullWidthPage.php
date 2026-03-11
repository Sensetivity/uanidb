<?php

namespace App\Filament\Concerns;

use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

trait FullWidthPage
{
    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getInfolistContentComponent(),
                $this->getRelationManagersContentComponent(),
            ]);
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }
}
