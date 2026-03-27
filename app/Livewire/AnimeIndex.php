<?php

namespace App\Livewire;

use App\Dto\AnimeFilterDto;
use App\Enums\AnimeSortEnum;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Models\Genre;
use App\Services\Frontend\AnimeService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AnimeIndex extends Component
{
    use WithPagination;

    #[Url(as: 'genre')]
    public string $genre = '';

    #[Url(as: 'score')]
    public string $score = '';

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'sort')]
    public string $sort = '';

    #[Url(as: 'status')]
    public string $status = '';

    #[Url(as: 'type')]
    public string $type = '';

    #[Url(as: 'view')]
    public string $view = 'grid';

    #[Url(as: 'year_from')]
    public string $yearFrom = '';

    #[Url(as: 'year_to')]
    public string $yearTo = '';

    public function render(AnimeService $animeService): View
    {
        $sortEnum = AnimeSortEnum::tryFrom($this->sort) ?? AnimeSortEnum::Popularity;

        $filterDto = new AnimeFilterDto(
            search: $this->search !== '' ? $this->search : null,
            types: $this->parseTypes(),
            statuses: $this->parseStatuses(),
            genres: $this->splitComma($this->genre),
            yearFrom: $this->yearFrom !== '' ? (int) $this->yearFrom : null,
            yearTo: $this->yearTo !== '' ? (int) $this->yearTo : null,
            minScore: $this->score !== '' ? (float) $this->score : null,
            sortBy: $sortEnum->column(),
            sortDirection: $sortEnum->direction(),
        );

        $animes = $animeService->getByFilters($filterDto, 24);
        $genres = Genre::query()->orderBy('name')->get();

        return view('livewire.anime-index', [
            'animes' => $animes,
            'genres' => $genres,
            'sortEnum' => $sortEnum,
            'typeOptions' => array_filter(
                AnimeTypeEnum::cases(),
                fn (AnimeTypeEnum $t) => $t !== AnimeTypeEnum::UNKNOWN,
            ),
            'statusOptions' => AnimeStatusEnum::cases(),
            'sortOptions' => AnimeSortEnum::cases(),
            'hasFilters' => $this->search !== '' || $this->type !== '' || $this->status !== ''
                || $this->genre !== '' || $this->yearFrom !== '' || $this->yearTo !== ''
                || $this->score !== '',
        ])->layout('components.layouts.app', [
            'title' => 'Каталог аніме - УкрАніме',
            'activeNav' => 'anime',
        ]);
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'type', 'status', 'genre', 'yearFrom', 'yearTo', 'score', 'sort']);
        $this->resetPage();
    }

    public function toggleGenre(string $slug): void
    {
        $this->genre = $this->toggleCommaSeparated($this->genre, $slug);
        $this->resetPage();
    }

    public function toggleStatus(string $slug): void
    {
        $this->status = $this->toggleCommaSeparated($this->status, $slug);
        $this->resetPage();
    }

    public function toggleType(string $slug): void
    {
        $this->type = $this->toggleCommaSeparated($this->type, $slug);
        $this->resetPage();
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'yearFrom', 'yearTo', 'score', 'sort'])) {
            $this->resetPage();
        }
    }

    /**
     * @return AnimeStatusEnum[]
     */
    private function parseStatuses(): array
    {
        $statuses = [];
        foreach ($this->splitComma($this->status) as $slug) {
            $enum = AnimeStatusEnum::fromSlug($slug);
            if ($enum) {
                $statuses[] = $enum;
            }
        }

        return $statuses;
    }

    /**
     * @return AnimeTypeEnum[]
     */
    private function parseTypes(): array
    {
        $types = [];
        foreach ($this->splitComma($this->type) as $slug) {
            $enum = AnimeTypeEnum::fromSlug($slug);
            if ($enum) {
                $types[] = $enum;
            }
        }

        return $types;
    }

    /**
     * @return string[]
     */
    private function splitComma(string $value): array
    {
        if ($value === '') {
            return [];
        }

        return array_filter(array_map('trim', explode(',', $value)));
    }

    private function toggleCommaSeparated(string $current, string $value): string
    {
        $items = $current === '' ? [] : array_filter(explode(',', $current));

        if (in_array($value, $items)) {
            $items = array_values(array_diff($items, [$value]));
        } else {
            $items[] = $value;
        }

        return implode(',', $items);
    }
}
