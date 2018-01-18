@extends('layouts.home')

@section('container')
    <div id="container">
        @if (!$articles->isEmpty())
            @foreach ($articles as $article)
                <section class="list">
                    <span class="titleimg">
                        <a href="{{ url('/show', [$article->id]) }}"><img width="270" height="165" src="http://127.0.0.1/emlog6/content/templates/ziblog/images/xxx.png" class="attachment-thumbnail wp-post-image" alt="{{ subString($article->title, 0, 45) }}" /></a>
                    </span>
                    <div class="mecc">
                        <a href="{{ url('/show', [$article->id]) }}" title="{{ subString($article->title, 0, 45) }}" class="comnum"><span class="up">{{ $article->comments->count() }}</span></a>
                        <h2 class="mecctitle">
                            <a href="{{ url('/show', [$article->id]) }}">{{ subString($article->title, 0, 45) }}</a>
                        </h2>
                        <address class="meccaddress"><time>{{ $article->updated_at->format('m.d') }}</time> - 未分类 - <a href="http://127.0.0.1/emlog6/author/1">{{ $article->user->name }}</a> - 阅 {{ $article->reads }} </address>
                    </div>
                    <div class="summary">
                        @if (!empty($article->excerpt))
                            {!! $article->excerpt !!}
                        @else
                        <p>
                            {{ extractHtmlData($article->body, $_SITECONFIG['excerpt_subnum']) }}
                        </p>
                        @endif
                    </div>
                    <div class="clear"></div>
                </section>
            @endforeach
            {{-- 电脑版分页 --}}
            {{ $articles->links('home.page') }}
            {{-- 手机版分页 --}}
            {{ $articles->links('home.simplepage') }}
        @endif
    </div>
@endsection