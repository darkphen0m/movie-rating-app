<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;
use Livewire\Wireable;

class MovieDetailData extends Data implements Wireable
{
    public function __construct(
        public string $imdbId,
        public string $title,
        public string $year,
        public string $rated,
        public string $runtime,
        public string $genre,
        public string $director,
        public string $writer,
        public string $actors,
        public string $plot,
        public ?string $posterUrl,
        public ?string $imdbRating,
        public ?string $metascore,
        public ?float $internalRating = null,
        public ?int $ratingsCount = null,
    ) {}

    public static function fromOmdbApi(array $data): self
    {
        return new self(
            imdbId: $data['imdbID'],
            title: $data['Title'],
            year: $data['Year'],
            rated: $data['Rated'] ?? 'N/A',
            runtime: $data['Runtime'] ?? 'N/A',
            genre: $data['Genre'] ?? 'N/A',
            director: $data['Director'] ?? 'N/A',
            writer: $data['Writer'] ?? 'N/A',
            actors: $data['Actors'] ?? 'N/A',
            plot: $data['Plot'] ?? 'N/A',
            posterUrl: isset($data['Poster']) && $data['Poster'] !== 'N/A'
                ? $data['Poster']
                : null,
            imdbRating: $data['imdbRating'] ?? null,
            metascore: $data['Metascore'] ?? null,
        );
    }

    public function withInternalRating(?float $rating, ?int $count): self
    {
        $this->internalRating = $rating;
        $this->ratingsCount = $count;

        return $this;
    }

    public function toLivewire()
    {
        return $this->toArray();
    }

    public static function fromLivewire($value)
    {
        return new self(
            imdbId: $value['imdbId'],
            title: $value['title'],
            year: $value['year'],
            rated: $value['rated'],
            runtime: $value['runtime'],
            genre: $value['genre'],
            director: $value['director'],
            writer: $value['writer'],
            actors: $value['actors'],
            plot: $value['plot'],
            posterUrl: $value['posterUrl'],
            imdbRating: $value['imdbRating'],
            metascore: $value['metascore'],
            internalRating: $value['internalRating'] ?? null,
            ratingsCount: $value['ratingsCount'] ?? null,
        );
    }
}
