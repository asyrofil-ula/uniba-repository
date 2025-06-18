@if ($paginator->hasPages())
    <nav class="inline-flex rounded-md shadow">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 rounded-l-md border bg-white text-gray-300 cursor-not-allowed">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="px-3 py-2 rounded-l-md border bg-white text-gray-500 hover:bg-gray-50">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 border-t border-b border-r bg-white text-gray-600">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 border-t border-b border-r bg-green-600 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-4 py-2 border-t border-b border-r bg-white text-gray-600 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="px-3 py-2 rounded-r-md border bg-white text-gray-500 hover:bg-gray-50">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span class="px-3 py-2 rounded-r-md border bg-white text-gray-300 cursor-not-allowed">
                <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif