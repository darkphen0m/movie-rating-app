<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'imdb_id',
        'title',
        'year',
        'poster_url',
    ];

    /**
     * Alle Bewertungen für diesen Film
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Durchschnittsbewertung für diesen Film
     */
    public function averageRating(): float
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    /**
     * Anzahl der Bewertungen
     */
    public function ratingsCount(): int
    {
        return $this->ratings()->count();
    }

    public function watchlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'watchlist');
    }
}
