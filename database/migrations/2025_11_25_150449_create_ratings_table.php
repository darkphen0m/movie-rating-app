<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('rating'); // 1-10
            $table->timestamps();

            // Ein User kann einen Film nur einmal bewerten
            $table->unique(['user_id', 'movie_id']);

            $table->index('movie_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
