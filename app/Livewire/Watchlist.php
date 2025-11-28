<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Watchlist extends Component
{
    public function render()
    {
        $movies = Auth::user()->watchlist()
            ->withCount('ratings')
            ->orderByDesc('watchlist.created_at')
            ->get();

        return view('livewire.watchlist', [
            'movies' => $movies
        ]);
    }
}
