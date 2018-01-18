@if ($paginator->hasPages())
    <div class="pagenavi">
        <span class="page-numbers">{{ $paginator->currentPage() }}/{{ $paginator->total() }}</span>
        @if (!$paginator->onFirstPage())
            <a class="page-numbers" href="{{ $paginator->url(1) }}">首页</a>
            <a class="page-numbers" href="{{ $paginator->previousPageUrl() }}" rel="prev">上页</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-numbers disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-numbers current">{{ $page }}</span>
                    @else
                        <a class="page-numbers" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="page-numbers" href="{{ $paginator->nextPageUrl() }}">下页</a>
            <a class="page-numbers" href="{{ $paginator->url($paginator->lastPage()) }}">末页</a>
        @endif
    </div>
@endif
