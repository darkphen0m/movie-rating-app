<?php

use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;
use Livewire\Livewire;
use App\Livewire\MovieSearch;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    // Mock OMDb API responses
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'Search' => [],
            'totalResults' => '0',
            'Response' => 'True'
        ], 200),
    ]);
});

test('authenticated user can access movie search page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('movie.search'))
        ->assertOk()
        ->assertSeeLivewire(MovieSearch::class);
});

test('guest cannot access movie search page', function () {
    $this->get(route('movie.search'))
        ->assertRedirect(route('login'));
});

test('movie search component renders correctly', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(MovieSearch::class)
        ->assertOk()
        ->assertSee('Filme suchen');
});
