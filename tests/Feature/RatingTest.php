<?php

use App\Models\User;
use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can access watchlist', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('watchlist'))
        ->assertOk();
});

test('guest cannot access watchlist', function () {
    $this->get(route('watchlist'))
        ->assertRedirect(route('login'));
});

test('user can add movie to watchlist', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    Watchlist::create([
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ]);

    expect(Watchlist::where('user_id', $user->id)->count())->toBe(1);
});

test('user can remove movie from watchlist', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    Watchlist::create([
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ]);

    Watchlist::where('user_id', $user->id)
        ->where('movie_id', $movie->id)
        ->delete();

    expect(Watchlist::where('user_id', $user->id)->count())->toBe(0);
});

test('user cannot add same movie to watchlist twice', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    Watchlist::create([
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ]);

    expect(fn() => Watchlist::factory()->create([
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ]))->toThrow(\Illuminate\Database\QueryException::class);
});
