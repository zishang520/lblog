@extends('layouts.home')

@section('container')
    <div id="container">
        <nav id="mbx">
            当前位置：<a href="{{ url('/') }}">首页</a> &gt; 未分类 &gt; 正文
        </nav>
        <!--mbx-->
        <article class="content">
            <header class="contenttitle">
                <a href="#respond" class="count" title="{{ subString($article->title, 0, 45) }}">{{ $article->comments->count() }}</a>
                <div class="mscc">
                    <h1 class="mscctitle">
                    <a href="{{ url('/show', [$article->id]) }}">{{ subString($article->title, 0, 45) }}</a>
                </h1>
                    <address class="msccaddress">
                        <em>已有{{ $article->reads }}人阅读此文</em> -
                        <time>{{ $article->updated_at->format('Y-m-d') }}</time> - 未分类 - <a href="http://127.0.0.1/emlog6/author/1">{{ $article->user->name }}</a> - @if(auth()->check()) <a href="{{ url('/admin/article/'.$article->id.'/edit') }}">编辑</a> @endif</address>
                </div>
            </header>
            <div class="content-text">
                {!! $article->body !!}
            </div>
            <footer class="article-tag">
            @if(is_array($article->tagSlugs()))
            @foreach ($article->tagSlugs() as $value)
                <label><a href="{{ url('/tag', [$value]) }}">{{ $value }}</a></label>
            @endforeach
            @endif
            </footer>
        </article>
        {{-- 上一篇文章和下一篇 --}}
        <nav class="nav-single">
            @if (!empty($prevarticle))
                <span class="nav-previous">
                    <a href="{{ url('/article', [$prevarticle->id]) }}">&laquo;    {{ subString($prevarticle->title, 0, 45) }}</a>
                </span>
            @endif
            @if (!empty($nextarticle))
                <span class="nav-next">
                    <a href="{{ url('/article', [$nextarticle->id]) }}">{{ subString($nextarticle->title, 0, 45) }}     &raquo;</a>
                </span>
            @endif
        </nav>
        <!--相关文章-->
        <div class="xianguan">
            <div class="xianguantitle">你喜欢下面的文章吗！Do you like the following articles?</div>
            <ul class="pic">
                <li>
                    <a href="http://127.0.0.1/emlog6/post-62.html"><img width="400" height="244" src="http://127.0.0.1/emlog6/content/templates/ziblog/images/xxx.png" class="attachment-medium wp-post-image" alt="fgbhnjmk" /></a><a rel="bookmark" href="http://127.0.0.1/emlog6/post-62.html" class="link">MYSQL 设计类型的选择</a></li>
                <li>
                    <a href="http://127.0.0.1/emlog6/post-58.html"><img width="400" height="244" src="http://127.0.0.1/emlog6/content/templates/ziblog/images/xxx.png" class="attachment-medium wp-post-image" alt="fgbhnjmk" /></a><a rel="bookmark" href="http://127.0.0.1/emlog6/post-58.html" class="link">PHP-SESSION的使用</a></li>
                <li>
                    <a href="http://127.0.0.1/emlog6/post-57.html"><img width="400" height="244" src="http://127.0.0.1/emlog6/content/templates/ziblog/images/xxx.png" class="attachment-medium wp-post-image" alt="fgbhnjmk" /></a><a rel="bookmark" href="http://127.0.0.1/emlog6/post-57.html" class="link">laravel开发积累</a></li>
                <li>
                    <a href="http://127.0.0.1/emlog6/post-79.html"><img width="400" height="244" src="http://127.0.0.1/emlog6/content/templates/ziblog/images/xxx.png" class="attachment-medium wp-post-image" alt="fgbhnjmk" /></a><a rel="bookmark" href="http://127.0.0.1/emlog6/post-79.html" class="link">123</a></li>
            </ul>
        </div>
        {{-- <div class="comment" id="comments">
            @if (!$article->comments->isEmpty())
            <ul id="comment">
                @foreach ($article->comments as $comment)
                    <li id="comment-12">
                       <span>
                           <a name="12"></a>
                           <div class="avatar"><img src="http://cn.gravatar.com/avatar/{{ md5($comment->email) }}?s=40&d=mm&r=g"></div>
                       </span>
                       <div class="mhcc">
                            <address>
                                <div class="comment-info">
                                    @if ($comment->website)
                                        <a href="{{ $comment->website }}" target="_blank">{{ $comment->nickname }}</a>
                                    @else
                                        <a href="javascript:void(0);">{{ $comment->nickname }}</a>
                                    @endif
                                </div>
                                <p>{{ $comment->content }}</p>
                                <span>{{ $comment->created_at }} - <a href="#content" class="replay" data-nickname="{{ $comment->nickname }}" data-id="{{ $comment->id }}">回复</a></span>
                            </address>
                        </div>
                    </li>
                @endforeach
            </ul>
            @endif
            <div id="pagenavi"></div>
            <div id="comment-place">
                <div class="title">期待你一针见血的评论，Come on！</div>
                @if (count($errors) > 0)
                     <div class="alert alert-danger in">
                        {!! implode('，', $errors->all()) !!}
                    </div>
                @endif
                <div id="respond">
                    <div class="cancel-reply" id="cancel-reply" style="display:none">
                        <a href="javascript:void(0);" onclick="cancelReply()">取消回复</a>
                    </div>
                    <p class="comment-header">
                        <b>发表评论：</b>
                        <a name="respond">123</a>
                    </p>
                    <form method="post" name="commentform" action="{{ url('comment') }}" id="commentform">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <input type="text" class="input" id="nickname" name="nickname" maxlength="49" value="{{ old('nickname') }}" size="22" tabindex="1" placeholder="昵称(必填)" required="required">
                        <input type="email" class="input" id="email" name="email" maxlength="128" value="{{ old('email') }}" size="22" tabindex="2" placeholder="邮箱(必填)" required="required">
                        <input type="url" class="input" id="website" name="website" maxlength="128" value="{{ old('website') }}" size="22" tabindex="3" placeholder="主页(选填)">
                        <textarea name="content" id="content" rows="7" tabindex="4" placeholder="输入评论内容..." required="required">{{ old('content') }}</textarea>
                        <input type="submit" id="submit" tabindex="2" value="提交评论" />
                    </form>
                </div>
            </div>
        </div> --}}
        <!--end #contentleft-->
    </div>
@endsection
