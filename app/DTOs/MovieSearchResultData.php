<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class MovieSearchResultData extends Data
{
    public function __construct(
        public string $imdbId,
        public string $title,
        public string $year,
        public string $type,
        public ?string $posterUrl,
        public ?float $internalRating = null,
        public ?int $ratingsCount = null,
    ) {}

    public static function fromOmdbApi(array $data): self
    {
        return new self(
            imdbId: $data['imdbID'],
            title: $data['Title'],
            year: $data['Year'],
            type: $data['Type'],
            posterUrl: isset($data['Poster']) && $data['Poster'] !== 'N/A'
                ? $data['Poster']
                : null,
        );
    }

    public function withInternalRating(float $rating, int $count): self
    {
        $this->internalRating = $rating;
        $this->ratingsCount = $count;

        return $this;
    }
}
