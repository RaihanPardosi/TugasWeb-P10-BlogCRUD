@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Navigasi halaman">
        @if ($paginator->onFirstPage())
            <span class="page is-disabled"><x-icon name="arrow-left" :size="16" /> Prev</span>
        @else
            <a class="page" href="{{ $paginator->previousPageUrl() }}" rel="prev"><x-icon name="arrow-left" :size="16" /> Prev</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page is-disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page is-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="page" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="page" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <x-icon name="arrow-right" :size="16" /></a>
        @else
            <span class="page is-disabled">Next <x-icon name="arrow-right" :size="16" /></span>
        @endif
    </nav>
@endif
