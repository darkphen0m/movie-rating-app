<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;
use Illuminate\Support\Collection;

class MovieSearchResponseData extends Data
{
    public function __construct(
        /** @var Collection<int, MovieSearchResultData> */
        public Collection $results,
        public int $totalResults,
        public bool $success,
    ) {}

    public static function fromOmdbApi(array $data): self
    {
        if (!isset($data['Response']) || $data['Response'] !== 'True') {
            return new self(
                results: collect([]),
                totalResults: 0,
                success: false,
            );
        }

        $results = collect($data['Search'] ?? [])
            ->map(fn(array $movie) => MovieSearchResultData::fromOmdbApi($movie));

        return new self(
            results: $results,
            totalResults: (int) ($data['totalResults'] ?? 0),
            success: true,
        );
    }
}
