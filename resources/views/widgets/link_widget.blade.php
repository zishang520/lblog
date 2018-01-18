<div class="sitebar_list">
    <div class="sitebar_title">
        <h4>{{ $config['title'] }}</h4>
    </div>
    <div class="tagg">
        <ul id="menu-link" class="menu">
        @if (!$links->isEmpty())
        @foreach ($links as $link)
            <li>
                <a href="{{ $link->siteurl }}" title="{{ $link->sitename }}" target="_blank">{{ $link->sitename }}</a>
            </li>
        @endforeach
        @endif
        </ul>
    </div>
</div>