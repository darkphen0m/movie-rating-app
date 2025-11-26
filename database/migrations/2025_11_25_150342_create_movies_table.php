<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('imdb_id')->unique();
            $table->string('title');
            $table->year('year')->nullable();
            $table->text('poster_url')->nullable();
            $table->timestamps();

            $table->index('imdb_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
