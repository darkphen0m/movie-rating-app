<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;

class RatedMoviesList extends Component
{
    public function render()
    {
        $movies = Movie::withCount('ratings')
            ->having('ratings_count', '>', 0)
            ->with('ratings')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.rated-movies-list', [
            'movies' => $movies
        ]);
    }
}
