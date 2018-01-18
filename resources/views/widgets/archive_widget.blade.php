<div class="sitebar_list">
    <div class="sitebar_title">
        <h4>{{ $config['title'] }}</h4>
    </div>
    <div class="tagg">
        <ul id="menu-archive" class="menu">
        @if (!$archives->isEmpty())
        @foreach ($archives as $archive)
            <li>
                <a href="{{ url($_SITECONFIG['blogurl'] . '/archive/' . $archive->created) }}" title="{{ $archive->num }} 篇文章">{{ $archive->created }}({{ $archive->num }})</a>
            </li>
        @endforeach
        @else
            <li>
                暂时还没有归档
            </li>
        @endif
        </ul>
    </div>
</div>