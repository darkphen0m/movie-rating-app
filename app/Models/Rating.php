<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Der User, der diese Bewertung abgegeben hat
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Der Film, der bewertet wurde
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
