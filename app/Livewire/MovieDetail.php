<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\OmdbService;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\Watchlist;
use App\DTOs\MovieDetailData;
use App\Actions\SaveMovieRating;
use App\Actions\ToggleWatchList;
use Illuminate\Support\Facades\Auth;

class MovieDetail extends Component
{
    public string $imdbId;
    public ?MovieDetailData $movie = null;
    public ?string $errorMessage = null;

    public ?int $userRating = null;
    public ?int $selectedRating = null;
    public ?string $backUrl = null;
    public bool $isOnWatchlist = false;

    public function mount(string $imdbId): void
    {
        $this->imdbId = $imdbId;
        $this->backUrl = url()->previous();
        $this->loadMovie();
    }

    public function loadMovie(): void
    {
        $omdbService = app(OmdbService::class);
        $this->movie = $omdbService->getMovieById($this->imdbId);

        if (!$this->movie) {
            $this->errorMessage = 'Film konnte nicht geladen werden.';
            return;
        }

        $movieRecord = Movie::where('imdb_id', $this->imdbId)->first();

        if ($movieRecord) {
            $this->movie = $this->movie->withInternalRating(
                $movieRecord->averageRating(),
                $movieRecord->ratingsCount()
            );

            if (Auth::check()) {
                $userRatingRecord = Rating::where('movie_id', $movieRecord->getKey())
                    ->where('user_id', Auth::id())
                    ->first();

                if ($userRatingRecord) {
                    $this->userRating = $userRatingRecord->rating;
                    $this->selectedRating = $userRatingRecord->rating;
                }

                $this->isOnWatchlist = Watchlist::where('user_id', Auth::id())
                    ->where('movie_id', $movieRecord->getKey())
                    ->exists();
            }
        }
    }

    public function setRating(int $rating): void
    {
        $this->selectedRating = $rating;
    }

    public function saveRating(): void
    {
        try {
            $saveRatingAction = app(SaveMovieRating::class);

            $saveRatingAction(
                Auth::id(),
                $this->imdbId,
                $this->selectedRating,
                $this->movie
            );

            $this->userRating = $this->selectedRating;
            $this->loadMovie();

            session()->flash('success', 'Bewertung erfolgreich gespeichert!');
        } catch (\InvalidArgumentException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function toggleWatchlist(): void
    {
        $toggleAction = app(ToggleWatchList::class);

        $added = $toggleAction(Auth::id(), $this->imdbId, $this->movie);

        $this->isOnWatchlist = $added;

        session()->flash(
            'success',
            $added ? 'Zur Watchlist hinzugefügt!' : 'Von Watchlist entfernt!'
        );
    }

    public function render()
    {
        return view('livewire.movie-detail');
    }
}
