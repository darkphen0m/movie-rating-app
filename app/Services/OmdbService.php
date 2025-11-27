<?php

namespace App\Services;

use App\DTOs\MovieDetailData;
use App\DTOs\MovieSearchResponseData;
use App\DTOs\MovieSearchResultData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OmdbService
{
    private string $apiKey;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.omdb.key');
        $this->apiUrl = config('services.omdb.url');
    }

    /**
     * Suche nach Filmen
     */
    public function search(string $query, int $page = 1): MovieSearchResponseData
    {
        try {
            $response = Http::get($this->apiUrl, [
                'apikey' => $this->apiKey,
                's' => str($query)->trim()->append("*"),
                'page' => $page,
                'type' => 'movie',
            ]);

            if ($response->successful()) {
                return MovieSearchResponseData::fromOmdbApi($response->json());
            }

            return MovieSearchResponseData::fromOmdbApi(['Response' => 'False']);
        } catch (\Exception $e) {
            Log::error('OMDb API search error: ' . $e->getMessage());
            return MovieSearchResponseData::fromOmdbApi(['Response' => 'False']);
        }
    }

    /**
     * Film-Details per IMDb ID abrufen
     */
    public function getMovieById(string $imdbId): ?MovieDetailData
    {
        try {
            $response = Http::get($this->apiUrl, [
                'apikey' => $this->apiKey,
                'i' => $imdbId,
                'plot' => 'full',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['Response']) && $data['Response'] === 'True') {
                    return MovieDetailData::fromOmdbApi($data);
                }
            }

            return null;
        } catch (\Exception $e) {
            Log::error('OMDb API getById error: ' . $e->getMessage());
            return null;
        }
    }
}
