<?php

namespace App\Actions;

use App\DTOs\MovieDetailData;
use App\Models\Movie;
use App\Models\Rating;

class SaveMovieRating
{
    public function __invoke(
        int $userId,
        string $imdbId,
        int $rating,
        MovieDetailData $movieDetails
    ): Rating {
        $this->validate($rating);

        $movie = $this->ensureMovieExists($imdbId, $movieDetails);

        return $this->saveRating($userId, $movie->getKey(), $rating);
    }

    protected function validate(int $rating): void
    {
        if ($rating < 1 || $rating > 10) {
            throw new \InvalidArgumentException('Rating must be between 1 and 10');
        }
    }

    protected function ensureMovieExists(string $imdbId, MovieDetailData $movieDetails): Movie
    {
        return Movie::firstOrCreate(
            ['imdb_id' => $imdbId],
            [
                'title' => $movieDetails->title,
                'year' => $movieDetails->year,
                'poster_url' => $movieDetails->posterUrl,
            ]
        );
    }

    protected function saveRating(int $userId, int $movieId, int $rating): Rating
    {
        return Rating::updateOrCreate(
            [
                'user_id' => $userId,
                'movie_id' => $movieId,
            ],
            [
                'rating' => $rating,
            ]
        );
    }
}
