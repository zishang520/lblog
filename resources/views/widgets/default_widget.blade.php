<div class="sitebar_list">
    <div class="sitebar_title">
        <h4>{{ $config['title'] }}</h4>
    </div>
    <div class="default">
        {!! (isset($config['content']) ? $config['content'] : '') !!}
    </div>
</div>