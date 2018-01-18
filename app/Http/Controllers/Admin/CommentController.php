<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    // 显示评论列表
    public function index($action = '')
    {
        switch ($action) {
            case 'hide':
                $type = 'hide';
                $where = ['hide' => 1];
                break;
            case 'pub':
                $type = 'pub';
                $where = ['hide' => 0];
                break;
            default:
                $type = 'index';
                $where = [];
                break;
        }
        $url = ['all' => url('/admin/comment/index'), 'hide' => url('/admin/comment/index/hide'), 'pub' => url('/admin/comment/index/pub')];
        return view('admin.comment.index')
            ->withComments(Comment::with('Article')
                    ->where($where)
                    ->orderBy('id', 'DESC')
                    ->sharedLock()
                    ->paginate(10))
            ->with('Urls', $url)
            ->with('hide_num', Comment::where('hide', 1)
                    ->count())
            ->with('type', $type);
    }

    // 显示指定文章的评论
    public function artid_index($id, $action = '')
    {
        switch ($action) {
            case 'hide':
                $type = 'hide';
                $where = ['article_id' => $id, 'hide' => 1];
                break;
            case 'pub':
                $type = 'pub';
                $where = ['article_id' => $id, 'hide' => 0];
                break;
            default:
                $type = 'index';
                $where = ['article_id' => $id];
                break;
        }
        $url = ['all' => url('/admin/comment/artid_index/' . $id), 'hide' => url('/admin/comment/artid_index/' . $id . '/hide'), 'pub' => url('/admin/comment/artid_index/' . $id . '/pub')];
        return view('admin.comment.index')
            ->withComments(Comment::with('Article')
                    ->where($where)
                    ->orderBy('id', 'DESC')
                    ->sharedLock()
                    ->paginate(10))
            ->with('Urls', $url)
            ->with('hide_num', Comment::where(['article_id' => $id, 'hide' => 1])
                    ->count())
            ->with('type', $type);
    }

    // 回复评论
    public function replay($id)
    {
        $comment = Comment::find($id);
        if (empty($comment)) {
            return redirect('admin/comment')->withErrors('指定的评论不存在！');
        }
        return view('admin.comment.replay')->withComment($comment);
    }

    // 隐藏单个
    public function hide($id)
    {
        if (Comment::where('id', $id)->update(['hide' => 1])) {
            return redirect('admin/comment');
        } else {
            return redirect()->back()->withErrors('隐藏失败！');
        }
    }

    // 审核单个
    public function pub($id)
    {
        if (Comment::where('id', $id)->update(['hide' => 0])) {
            return redirect('admin/comment');
        } else {
            return redirect()->back()->withErrors('审核失败！');
        }
    }
    // 管理员添加评论
    public function store(Request $request)
    {
        // 数据验证
        $this->validate($request, [
            'content' => 'required', // 必填
            'article_id' => 'required|exists:articles,id',
        ]);
        // 通过 Comment Model 插入一条数据进 comments 表
        $comment = new Comment; // 初始化 Comment 对象
        $comment->content = $request->get('content'); //内容
        $comment->article_id = $request->get('article_id'); //文章id
        $comment->website = url('/'); //网站url
        $comment->email = $request->user()->email; // 用户邮箱
        $comment->nickname = $request->user()->name; //用户名
        $comment->ip = $request->ip(); //IP

        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if ($comment->save()) {
            return redirect('admin/comment'); // 保存成功，跳转到 文章管理 页
        } else {
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    // 编辑评论
    public function edit($id)
    {
        $comment = Comment::find($id);
        if (empty($comment)) {
            return redirect('admin/comment')->withErrors('指定的评论不存在！');
        }
        return view('admin.comment.edit')->withComment($comment);
    }

    // 更新评论
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nickname' => 'bail|required|max:12',
            'email' => 'bail|required|email',
            'website' => 'bail|sometimes|nullable|url',
            'content' => 'required|max:512',
        ]);

        $comment = Comment::find($id);
        if (empty($comment)) {
            return redirect('admin/comment')->withErrors('指定的评论不存在！');
        }
        $comment->nickname = $request->get('nickname');
        $comment->email = $request->get('email');
        $comment->website = $request->get('website');
        $comment->content = $request->get('content');

        if ($comment->save()) {
            return redirect('admin/comment');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    // 自定义操作组
    public function actions(Request $request)
    {
        $this->validate($request, [
            'com' => 'bail|required|array',
            'method' => 'required|alpha|in:del,pub,hide',
        ]);
        // 获取请求操作
        $method = $request->get('method');
        // 获取需要操作的id列表
        $com = array_map('intval', $request->get('com'));
        switch ($method) {
            // 删除
            case 'del':
                if (Comment::whereIn('id', $com)->delete()) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('删除失败！');
                }
                break;
            // 显示
            case 'pub':
                if (Comment::whereIn('id', $com)->update(['hide' => 0])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('审核失败！');
                }
                break;
            // 隐藏
            case 'hide':
                if (Comment::whereIn('id', $com)->update(['hide' => 1])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('隐藏失败！');
                }
                break;
        }
    }

    // 删除指定IP的评论
    public function del_ip($ip)
    {
        if (Comment::where('ip', $ip)->delete()) {
            return redirect('admin/comment');
        } else {
            return redirect()->back()->withErrors('删除失败！');
        }
    }

    // 删除一条评论
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (empty($comment)) {
            return redirect('admin/comment')->withErrors('指定的评论不存在！');
        }
        if ($comment->delete()) {
            return redirect('admin/comment');
        } else {
            return redirect()->back()->withErrors('删除失败！');
        }
    }
}
