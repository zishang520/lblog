<div class="sitebar_list">
    <div class="sitebar_title">
        <h4>{{ $config['title'] }}</h4>
    </div>
    <ul class="sitebar_list_ul">
        @if (!$comments->isEmpty())
        @foreach ($comments as $comment)
            <li>
                <a href="{{ url($_SITECONFIG['blogurl'] . '/article/' . $comment->article_id) }}#comment-{{ $comment->id }}" title="{{ $comment->content }}">
                    <b>{{ $comment->nickname }}: </b>
                    {{ extractHtmlData($comment->content, (isset($config['comment_subnum']) ? $config['comment_subnum'] : 10)) }}
                </a>
            </li>
        @endforeach
        @else
            <li>
                暂时还没有评论
            </li>
        @endif
    </ul>
</div>
