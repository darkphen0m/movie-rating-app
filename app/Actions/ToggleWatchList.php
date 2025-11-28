<?php

namespace App\Actions;

use App\DTOs\MovieDetailData;
use App\Models\Movie;
use App\Models\Watchlist;

class ToggleWatchList
{
    public function __invoke(int $userId, string $imdbId, MovieDetailData $movieDetails): bool
    {
        $movie = $this->ensureMovieExists($imdbId, $movieDetails);

        $exists = Watchlist::where('user_id', $userId)
            ->where('movie_id', $movie->getKey())
            ->exists();

        if ($exists) {
            Watchlist::where('user_id', $userId)
                ->where('movie_id', $movie->getKey())
                ->delete();
            return false;
        } else {
            Watchlist::create([
                'user_id' => $userId,
                'movie_id' => $movie->getKey(),
            ]);
            return true;
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
}
