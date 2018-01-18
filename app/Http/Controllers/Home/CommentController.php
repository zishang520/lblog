<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\BaseController;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    // 提交评论
    public function store(Request $request)
    {
        // 验证
        $this->validate($request, [
            'nickname' => 'required|max:36',
            'email' => 'required|email',
            'website' => 'sometimes|nullable|url',
            'content' => 'required|max:512',
            'article_id' => 'required|exists:articles,id',
        ]);

        $comment = new Comment; // 初始化 Comment 对象
        $comment->content = $request->get('content'); //内容
        $comment->article_id = $request->get('article_id'); //文章id
        $comment->website = $request->get('website'); //网站url
        $comment->email = $request->get('email'); // 用户邮箱
        $comment->nickname = $request->get('nickname'); //用户名
        $comment->ip = $request->ip(); //IP
        // 插入数据库
        if ($comment->save()) {
            return redirect()->back();
        } else {
            return redirect()->back()->withInput()->withErrors('评论发表失败！');
        }
    }
}
