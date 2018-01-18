<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\BaseController;
use App\Models\Article;
use Config;

class IndexController extends BaseController
{
    // 文章列表
    public function index()
    {
        return view('home.index')->withArticles(Article::where(['hide' => 0, 'type' => 0])
                ->with('Comments', 'User')
                ->orderBy('top', 'DESC')
                ->orderBy('id', 'DESC')
                ->sharedLock()->paginate(Config::get('siteconfig.index_lognum', 10)));
    }

    // 显示文章
    public function show($id)
    {
        $article = Article::with(['Comments' => function ($query) {
            $query->where('hide', 0);
        }, 'User'])->find($id);
        if (empty($article)) {
            return abort(404);
        }
        $article->increment('reads'); // 阅读量
        return view('home.show')
            ->withArticle($article)
            ->withPrevarticle(Article::where('id', '<', $article->id)->where(['hide' => 0, 'type' => 0])->select('id', 'title')->orderBy('id', 'DESC')->first())
            ->withNextarticle(Article::where('id', '>', $article->id)->where(['hide' => 0, 'type' => 0])->select('id', 'title')->orderBy('id', 'ASC')->first());
    }
}
