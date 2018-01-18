@if ($paginator->hasPages())
    <nav class="navigation">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <div class="nav-next"><a href="{{ $paginator->previousPageUrl() }}">上一页</a></div>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <div class="nav-previous"><a href="{{ $paginator->nextPageUrl() }}">下一页</a></div>
        @endif
    </nav>
@endif
