<?php

use App\Livewire\Watchlist;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

use App\Livewire\MovieSearch;
use App\Livewire\MovieDetail;
use App\Livewire\RatedMoviesList;

Route::get('/', function () {
    return redirect()->route('movies.rated');
});

Route::get('/rated-movies', RatedMoviesList::class)->name('movies.rated');

Route::middleware(['auth'])->group(function () {
    Route::get('/search', MovieSearch::class)->name('movie.search');
    Route::get('/movie/{imdbId}', MovieDetail::class)->name('movie.detail');
    Route::get('/watchlist', Watchlist::class)->name('watchlist');

    Route::get('/dashboard', function () {
        return redirect()->route('movie.search');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
