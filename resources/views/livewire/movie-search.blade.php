<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Filme suchen</h2>

            {{-- Search Input --}}
            <div class="mb-8">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Filmtitel eingeben..."
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring focus:ring-indigo-500"
                >
            </div>

            {{-- Results Count --}}
            @if($totalResults > 0)
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-semibold">{{ $totalResults }}</span>
                    Filme gefunden (Seite {{ $currentPage }} von {{ $totalPages }})
                </div>
            @endif

            {{-- Results --}}
            @if(!empty($results))
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($results as $movie)
                        <a href="{{ route('movie.detail', $movie['imdbId']) }}"
                           wire:navigate
                           class="bg-white dark:bg-gray-700 rounded-lg shadow hover:shadow-lg transition">

                            @if(!empty($movie['posterUrl']))
                                <img src="{{ $movie['posterUrl'] }}"
                                     alt="{{ $movie['title'] }}"
                                     class="w-full object-cover rounded-t-lg">
                            @else
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-t-lg flex items-center justify-center" style="height: 300px;">
                                    <span class="text-gray-400">Kein Bild</span>
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">
                                    {{ $movie['title'] }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $movie['year'] }}
                                </p>

                                @if(isset($movie['internalRating']))
                                    <div class="mt-2 flex items-center gap-1">
                                        <span class="text-sm">⭐</span>
                                        <span class="text-sm font-semibold text-white">{{ number_format($movie['internalRating'], 1) }}</span>
                                        <span class="text-xs text-gray-500">({{ $movie['ratingsCount'] }})</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="py-4 flex items-center justify-center gap-2">
                    {{-- Previous Button --}}
                    <button
                        wire:click="previousPage"
                        @if($currentPage <= 1) disabled @endif
                        class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 disabled:opacity-25"
                    >
                        ← Zurück
                    </button>

                    {{-- Page Numbers --}}
                    <div class="flex gap-2">
                        @php
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);
                        @endphp

                        @if($startPage > 1)
                            <button wire:click="goToPage(1)" class="px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
                                1
                            </button>
                            @if($startPage > 2)
                                <span class="px-3 py-2 text-gray-500">...</span>
                            @endif
                        @endif

                        @for($i = $startPage; $i <= $endPage; $i++)
                            <button
                                wire:click="goToPage({{ $i }})"
                                class="px-3 py-2 rounded-lg border {{ $i === $currentPage
                                    ? 'bg-indigo-600 text-white border-indigo-600'
                                    : 'bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200'
                                }}"
                            >
                                {{ $i }}
                            </button>
                        @endfor

                        @if($endPage < $totalPages)
                            @if($endPage < $totalPages - 1)
                                <span class="px-3 py-2 text-gray-500">...</span>
                            @endif
                            <button wire:click="goToPage({{ $totalPages }})" class="px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
                                {{ $totalPages }}
                            </button>
                        @endif
                    </div>

                    {{-- Next Button --}}
                    <button
                        wire:click="nextPage"
                        @if($currentPage >= $totalPages) disabled @endif
                        class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 disabled:opacity-25"
                    >
                        Weiter →
                    </button>
                </div>
            @endif

            @if(empty($results) && strlen($search) >= 2)
                <p class="text-center text-gray-600 dark:text-gray-400 py-8">
                    Keine Filme gefunden.
                </p>
            @endif

        </div>
    </div>
</div>
