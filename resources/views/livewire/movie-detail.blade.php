<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if($errorMessage)
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <p class="text-red-800 dark:text-red-200">{{ $errorMessage }}</p>
                </div>
                <div class="mb-6">
                    <a href="{{ $backUrl }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Zurück
                    </a>
                </div>
            </div>
        @elseif($movie)
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                @if (session()->has('success'))
                    <div class="p-4 bg-green-600 border-b border-green-200 dark:border-green-800">
                        <p class="text-white">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="p-4 bg-red-600 border-b border-red-200 dark:border-red-800">
                        <p class="text-white">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="p-6">
                    <div class="mb-6">
                        <a href="{{ $backUrl }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Zurück
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <div class="lg:col-span-1">
                            @if($movie->posterUrl)
                                <img src="{{ $movie->posterUrl }}"
                                     alt="{{ $movie->title }}"
                                     class="w-full rounded-lg shadow-lg">
                            @else
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center" style="height: 450px;">
                                    <span class="text-gray-400">Kein Poster</span>
                                </div>
                            @endif

                                <button
                                    wire:click="toggleWatchlist"
                                    class="w-full mt-4 px-4 py-3 rounded-lg font-semibold transition {{ $isOnWatchlist
            ? 'bg-red-600 hover:bg-red-700 text-white'
            : 'bg-indigo-600 hover:bg-indigo-700 text-white'
        }}"
                                >
                                    @if($isOnWatchlist)
                                        ✓ Auf Watchlist
                                    @else
                                        + Zur Watchlist hinzufügen
                                    @endif
                                </button>


                                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-3">Bewertungen</h3>

                                @if($movie->internalRating)
                                    <div class="mb-3 pb-3 border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Movie Rating App</span>
                                            <div class="flex items-center gap-2">
                                                <span>⭐</span>
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($movie->internalRating, 1) }}/10</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $movie->ratingsCount }} {{ $movie->ratingsCount === 1 ? 'Bewertung' : 'Bewertungen' }}
                                        </p>
                                    </div>
                                @endif

                                @if($movie->imdbRating && $movie->imdbRating !== 'N/A')
                                    <div class="mb-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">IMDb</span>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $movie->imdbRating }}/10</span>
                                        </div>
                                    </div>
                                @endif

                                @if($movie->metascore && $movie->metascore !== 'N/A')
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Metascore</span>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $movie->metascore }}/100</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <h1 class="text-4xl font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $movie->title }}
                            </h1>

                            <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400 mb-6">
                                <span>{{ $movie->year }}</span>
                                <span>•</span>
                                <span>{{ $movie->rated }}</span>
                                <span>•</span>
                                <span>{{ $movie->runtime }}</span>
                            </div>

                            <div class="mb-6">
                                <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-sm text-gray-700 dark:text-gray-300">
                                    {{ $movie->genre }}
                                </span>
                            </div>

                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Handlung</h2>
                                <p class="text-gray-700 dark:text-gray-300">
                                    {{ $movie->plot }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Regie</h3>
                                    <p class="text-gray-900 dark:text-white">{{ $movie->director }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Drehbuch</h3>
                                    <p class="text-gray-900 dark:text-white">{{ $movie->writer }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Darsteller</h3>
                                    <p class="text-gray-900 dark:text-white">{{ $movie->actors }}</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                    Deine Bewertung
                                </h2>

                                <div class="mb-6">
                                    <div class="flex items-center gap-2 mb-4">
                                        @for($i = 1; $i <= 10; $i++)
                                            <button
                                                wire:click="setRating({{ $i }})"
                                                class="w-12 h-12 rounded-lg border-2 font-semibold
                                                    {{ $selectedRating === $i
                                                        ? 'border-indigo-600 bg-indigo-600 text-white text-xl shadow-xl'
                                                        : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-gray-700'
                                                    }}"
                                                type="button"
                                            >
                                                {{ $i }}
                                            </button>
                                        @endfor
                                    </div>

                                    <button
                                        wire:click="saveRating"
                                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg disabled:opacity-25"
                                        type="button"
                                        @if(!$selectedRating) disabled @endif
                                    >
                                        {{ $userRating ? 'Bewertung aktualisieren' : 'Bewertung speichern' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
