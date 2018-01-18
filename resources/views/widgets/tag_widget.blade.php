<div class="sitebar_list">
    <div class="sitebar_title">
        <h4>{{ $config['title'] }}</h4>
    </div>
    <div class="tagg">
        <ul id="menu-tag" class="menu">
        @if (!$tags->isEmpty())
        @foreach ($tags as $tag)
            <li>
                <a href="{{ url($_SITECONFIG['blogurl'] . '/tag/' . $tag->id) }}" title="0 篇文章">{{ $tag->slug }}</a>
            </li>
        @endforeach
        @else
            <li>
                暂时还没有标签
            </li>
        @endif
        </ul>
    </div>
</div>