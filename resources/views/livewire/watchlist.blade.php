<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Meine Watchlist</h2>

            @if($movies->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        Deine Watchlist ist leer.
                    </p>
                    <a href="{{ route('movie.search') }}" wire:navigate class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Filme entdecken →
                    </a>
                </div>
            @else
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-semibold">{{ $movies->count() }}</span>
                    {{ $movies->count() === 1 ? 'Film' : 'Filme' }} auf deiner Watchlist
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
                                    <span class="text-gray-400 dark:text-gray-500">Kein Bild</span>
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">
                                    {{ $movie->title }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $movie->year }}
                                </p>

                                @if($movie->ratings_count > 0)
                                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center gap-1">
                                            <span class="text-sm">⭐</span>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($movie->averageRating(), 1) }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $movie->ratings_count }})</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
