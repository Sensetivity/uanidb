<?php

namespace App\Livewire\Anime;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Episode;
use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class AnimeTabs extends Component
{
    #[Url(as: 'tab')]
    public string $activeTab = 'overview';

    public Anime $anime;

    /**
     * @return Collection<int, Character>
     */
    #[Computed]
    public function characters(): Collection
    {
        /** @var Collection<int, Character> */
        return $this->anime->characters()
            ->withPivot('role')
            ->with('media')
            ->orderByRaw("CASE anime_character.role WHEN 'Main' THEN 1 WHEN 'Supporting' THEN 2 ELSE 3 END")
            ->get();
    }

    /**
     * @return Collection<int, Episode>
     */
    #[Computed]
    public function episodes(): Collection
    {
        /** @var Collection<int, Episode> */
        return $this->anime->episodes()
            ->orderBy('number')
            ->get();
    }

    /**
     * @return Collection<int, Anime>
     */
    #[Computed]
    public function relatedAnime(): Collection
    {
        /** @var Collection<int, Anime> */
        return $this->anime->relatedAnime()
            ->withPivot('relation_type')
            ->with('media')
            ->get();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.anime.anime-tabs');
    }

    public function selectTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    /**
     * @return Collection<int, Person>
     */
    #[Computed]
    public function staff(): Collection
    {
        /** @var Collection<int, Person> */
        return $this->anime->people()
            ->withPivot('role')
            ->with('media')
            ->get();
    }
}
