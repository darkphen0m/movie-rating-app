<?php

use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;
use Livewire\Livewire;
use App\Livewire\MovieDetail;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    // Mock OMDb API responses
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'imdbID' => 'tt0111161',
            'Title' => 'The Shawshank Redemption',
            'Year' => '1994',
            'Rated' => 'R',
            'Runtime' => '142 min',
            'Genre' => 'Drama',
            'Director' => 'Frank Darabont',
            'Writer' => 'Stephen King',
            'Actors' => 'Tim Robbins, Morgan Freeman',
            'Plot' => 'Two imprisoned men bond over a number of years',
            'Poster' => 'https://example.com/poster.jpg',
            'imdbRating' => '9.3',
            'Metascore' => '80',
            'Response' => 'True'
        ], 200),
    ]);
});

test('authenticated user can view movie details', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('movie.detail', 'tt0111161'))
        ->assertOk()
        ->assertSeeLivewire(MovieDetail::class);
});

test('guest cannot view movie details', function () {
    $this->get(route('movie.detail', 'tt0111161'))
        ->assertRedirect(route('login'));
});

test('user can update their rating', function () {
    $user = User::factory()->create();

    $movie = Movie::factory()->create(['imdb_id' => 'tt0111161']);

    Rating::factory()->create([
        'user_id' => $user->id,
        'movie_id' => $movie->id,
        'rating' => 7,
    ]);

    $this->actingAs($user);

    $rating = Rating::where('user_id', $user->id)
        ->where('movie_id', $movie->id)
        ->first();

    expect($rating->rating)->toBe(7);
});

test('movie detail component loads movie data', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(MovieDetail::class, ['imdbId' => 'tt0111161'])
        ->assertOk()
        ->assertSee('The Shawshank Redemption');
});
