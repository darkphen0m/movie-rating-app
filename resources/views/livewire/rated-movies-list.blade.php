<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Bewertete Filme</h2>

            @if($movies->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        Noch keine Filme bewertet.
                    </p>
                    <a href="{{ route('movie.search') }}" wire:navigate class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                        Zur Filmsuche →
                    </a>
                </div>
            @else
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-semibold">{{ $movies->count() }}</span>
                    {{ $movies->count() === 1 ? 'Film wurde' : 'Filme wurden' }} bewertet
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($movies as $movie)
                        <a href="{{ route('movie.detail', $movie->imdb_id) }}"
                           wire:navigate
                           class="bg-white dark:bg-gray-700 rounded-lg shadow hover:shadow-lg transition">

                            @if($movie->poster_url)
                                <img src="{{ $movie->poster_url }}"
                                     alt="{{ $movie->title }}"
                                     class="w-full object-cover rounded-t-lg">
                            @else
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-t-lg flex items-center justify-center" style="height: 300px;">
                                    <span class="text-gray-400">Kein Bild</span>
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">
                                    {{ $movie->title }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $movie->year }}
                                </p>

                                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1">
                                            <span class="text-sm">⭐</span>
                                            <span class="text-sm font-semibold text-white">{{ number_format($movie->averageRating(), 1) }}</span>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $movie->ratings_count }} {{ $movie->ratings_count === 1 ? 'Bewertung' : 'Bewertungen' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
