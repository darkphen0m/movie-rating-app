<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\OmdbService;
use App\Models\Movie;
use App\Models\Rating;
use App\DTOs\MovieDetailData;
use App\Actions\SaveMovieRating;
use Illuminate\Support\Facades\Auth;

class MovieDetail extends Component
{
    public string $imdbId;
    public ?MovieDetailData $movie = null;
    public ?string $errorMessage = null;

    public ?int $userRating = null;
    public ?int $selectedRating = null;

    public function mount(string $imdbId)
    {
        $this->imdbId = $imdbId;
        $this->loadMovie();
    }

    public function loadMovie()
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

            $userRatingRecord = Rating::where('movie_id', $movieRecord->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($userRatingRecord) {
                $this->userRating = $userRatingRecord->rating;
                $this->selectedRating = $userRatingRecord->rating;
            }
        }
    }

    public function setRating(int $rating)
    {
        $this->selectedRating = $rating;
    }

    public function saveRating()
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

    public function render()
    {
        return view('livewire.movie-detail');
    }
}
