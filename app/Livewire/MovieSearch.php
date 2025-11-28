<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\OmdbService;
use App\Models\Movie;

class MovieSearch extends Component
{
    public string $search = '';
    public array $results = [];
    public int $currentPage = 1;
    public int $totalResults = 0;
    public int $totalPages = 0;

    public function updatedSearch(): void
    {
        $this->currentPage = 1; // Reset auf Seite 1 bei neuer Suche

        if (strlen($this->search) >= 2) {
            $this->searchMovies();
        } else {
            $this->resetResults();
        }
    }

    public function searchMovies(): void
    {
        $omdbService = app(OmdbService::class);
        $response = $omdbService->search($this->search, $this->currentPage);

        if ($response->success) {
            $this->results = $response->results->toArray();
            $this->totalResults = $response->totalResults;
            $this->totalPages = (int) ceil($response->totalResults / 10); // 10 Ergebnisse pro Seite
            $this->withRatings();
        } else {
            $this->resetResults();
        }
    }

    public function goToPage(int $page): void
    {
        if ($page >= 1 && $page <= $this->totalPages) {
            $this->currentPage = $page;
            $this->searchMovies();

            // Scroll to top
            $this->dispatch('scroll-to-top');
        }
    }

    public function nextPage(): void
    {
        if ($this->currentPage < $this->totalPages) {
            $this->goToPage($this->currentPage + 1);
        }
    }

    public function previousPage(): void
    {
        if ($this->currentPage > 1) {
            $this->goToPage($this->currentPage - 1);
        }
    }

    protected function resetResults(): void
    {
        $this->results = [];
        $this->totalResults = 0;
        $this->totalPages = 0;
        $this->currentPage = 1;
    }

    protected function withRatings(): void
    {
        $imdbIds = collect($this->results)->pluck('imdbId')->toArray();

        $ratedMovies = Movie::whereIn('imdb_id', $imdbIds)
            ->withCount('ratings')
            ->get()
            ->keyBy('imdb_id');

        foreach ($this->results as &$result) {
            if ($ratedMovies->has($result['imdbId'])) {
                $movie = $ratedMovies->get($result['imdbId']);
                $result['internalRating'] = $movie->averageRating();
                $result['ratingsCount'] = $movie->ratings_count;
            }
        }
    }

    public function render()
    {
        return view('livewire.movie-search');
    }
}
