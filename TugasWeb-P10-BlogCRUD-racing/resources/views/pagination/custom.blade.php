@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Navigasi halaman">
        @if ($paginator->onFirstPage())
            <span class="page page--disabled" aria-disabled="true"><x-icon name="chevron-left" :size="16" /></span>
        @else
            <a class="page" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya"><x-icon name="chevron-left" :size="16" /></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page page--gap">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page page--current" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="page" href="{{ $url }}" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="page" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya"><x-icon name="chevron-right" :size="16" /></a>
        @else
            <span class="page page--disabled" aria-disabled="true"><x-icon name="chevron-right" :size="16" /></span>
        @endif
    </nav>
@endif
