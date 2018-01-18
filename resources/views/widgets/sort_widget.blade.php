<div class="sitebar_list">
    <div class="sitebar_title">
        <h4>{{ $config['title'] }}</h4>
    </div>
    <div class="tagg">
        <ul id="menu-sort" class="menu">
        @if (!$sorts->isEmpty())
        @foreach ($sorts as $sort)
            <li>
                <a href="{{ url($_SITECONFIG['blogurl'] . '/sort/' . $sort->id) }}" title="{{ $sort->sortname }}">{{ $sort->sortname }}</a>
            </li>
        @endforeach
        @else
            <li>
                暂时还没有分类
            </li>
        @endif
        </ul>
    </div>
</div>