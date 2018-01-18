<div class="sitebar_list">
    <div class="sitebar_title">
        <h4>{{ $config['title'] }}</h4>
    </div>
    <ul class="sitebar_list_ul">
        @if (!$articles->isEmpty())
        @foreach ($articles as $article)
            <li>
                <a href="{{ url($_SITECONFIG['blogurl'] . '/article/' . $article->id) }}" title="{{ $article->title }}">{{ $article->title }}</a>
            </li>
        @endforeach
        @else
            <li>
                暂时还没有文章
            </li>
        @endif
    </ul>
</div>