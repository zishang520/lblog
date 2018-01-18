<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Article;
use App\Models\Sort;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends BaseController
{
    /**
     * [index 文章页面]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2016-08-23T18:21:20+0800
     * @copyright (c)                      ZiShang520    All Rights Reserved
     * @return    [type]                   [description]
     */
    public function index()
    {
        $route = [
            'index' => url('/admin/article'),
            'draft' => url('/admin/article/draft'),
        ];
        return view('admin.article.index')
            ->withArticles(Article::where(['hide' => 0, 'type' => 0])
                    ->with('Comments', 'User')
                    ->orderBy('top', 'DESC')
                    ->orderBy('sorttop', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->sharedLock()
                    ->paginate(10))
            ->withSorts(Sort::all())
            ->withTags(Tag::all())
            ->withRoute($route);
    }

    // 查看草稿箱
    public function draft()
    {
        $route = [
            'index' => url('/admin/article'),
            'draft' => url('/admin/article/draft'),
        ];
        return view('admin.article.draft')
            ->withArticles(Article::where(['hide' => 1, 'type' => 0])
                    ->with('Comments', 'User')
                    ->orderBy('id', 'DESC')
                    ->sharedLock()
                    ->paginate(10))
            ->withSorts(Sort::all())
            ->withTags(Tag::all())
            ->withRoute($route);
    }

    // 根据分类来查看
    public function sort_id_index($id, $action = '')
    {
        switch ($action) {
            case 'draft':
                $view = 'admin.article.draft';
                $where = ['hide' => 1, 'type' => 0, 'sort_id' => $id];
                break;
            default:
                $view = 'admin.article.index';
                $where = ['hide' => 0, 'type' => 0, 'sort_id' => $id];
                break;
        }
        $route = [
            'index' => url('/admin/article/sort_id_index/' . $id),
            'draft' => url('/admin/article/sort_id_index/' . $id . '/draft'),
        ];
        return view($view)->withArticles(Article::where($where)->with('Comments', 'User')->orderBy('id', 'DESC')->sharedLock()->paginate(10))->withSorts(Sort::all())->with('sortid', $id)->withTags(Tag::all())->withRoute($route);
    }
    // 根据用户来查看
    public function user($id, $action = '')
    {
        switch ($action) {
            case 'draft':
                $view = 'admin.article.draft';
                $where = ['hide' => 1, 'type' => 0, 'user_id' => $id];
                break;
            default:
                $view = 'admin.article.index';
                $where = ['hide' => 0, 'type' => 0, 'user_id' => $id];
                break;
        }
        $route = [
            'index' => url('/admin/article/user/' . $id),
            'draft' => url('/admin/article/user/' . $id . '/draft'),
        ];
        return view($view)->withArticles(Article::where($where)->with('Comments', 'User')->orderBy('id', 'DESC')->sharedLock()->paginate(10))->withSorts(Sort::all())->withTags(Tag::all())->withRoute($route);
    }
    // 根据分类来查看
    public function tag_index($tag, $action = '')
    {
        switch ($action) {
            case 'draft':
                $view = 'admin.article.draft';
                $where = ['hide' => 1, 'type' => 0];
                break;
            default:
                $view = 'admin.article.index';
                $where = ['hide' => 0, 'type' => 0];
                break;
        }
        $route = [
            'index' => url('/admin/article/tag_index/' . $tag),
            'draft' => url('/admin/article/tag_index/' . $tag . '/draft'),
        ];
        return view($view)->withArticles(Article::withAnyTag([$tag])->where($where)->with('Comments', 'User')->orderBy('id', 'DESC')->sharedLock()->paginate(10))->withSorts(Sort::all())->with('tag', $tag)->withTags(Tag::all())->withRoute($route);
    }

    /**
     * [create 创建文章]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2016-08-23T18:21:09+0800
     * @copyright (c)                      ZiShang520    All Rights Reserved
     * @return    [type]                   [description]
     */
    public function create()
    {
        return view('admin.article.create')->withSorts(Sort::all())->withTags(Tag::all());
    }

    /**
     * [store 保存文章]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2016-08-23T18:24:06+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     Request                  $request   [依赖注入]
     * @return    [type]                              [description]
     */
    public function store(Request $request) // Laravel 的依赖注入系统会自动初始化我们需要的 Request 类

    {
        // 数据验证
        $this->validate($request, [
            'title' => 'bail|required|max:255', // 必填、在 articles 表中唯一、最大长度 255
            // 'body' => 'sometimes|nullable', // 必填
            'updated_at' => 'required|date_format:Y-m-d H:i:s', // 必填
        ]);
        // 通过 Article Model 插入一条数据进 articles 表
        $article = new Article; // 初始化 Article 对象
        $article->sort_id = $request->get('sort_id', 0); // 分类id
        $article->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 article 的 title 属性
        $article->body = $request->get('body'); // 同上
        $article->excerpt = $request->get('excerpt'); // 同上
        $article->top = $request->get('top', 0); // 置顶
        $article->sorttop = $request->get('sorttop', 0); // 置顶
        $article->allow_remark = $request->get('allow_remark', 0); // 是否允许评论
        $article->updated_at = $request->get('updated_at');
        $article->user_id = $request->user()->id; // 获取当前 Auth 系统中注册的用户，并将其 id 赋给 article 的 user_id 属性
        $article->hide = $request->get('hide', 0); //隐藏
        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if ($article->save()) {
            $request->filled('tag') && $article->tag($request->get('tag'));
            if ($request->ajax()) {
                return response()->json(['status' => true, 'msg' => '保存成功！', 'id' => $article->id]);
            }
            return redirect('admin/article'); // 保存成功，跳转到 文章管理 页
        } else {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'msg' => '保存失败！', 'id' => null]);
            }
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * [edit 编辑文章]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2016-08-23T18:46:40+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     [type]                   $id        [description]
     * @return    [type]                              [description]
     */
    public function edit($id)
    {
        $article = Article::find($id);
        if (empty($article)) {
            return redirect('admin/article')->withErrors('指定的文章不存在！');
        }
        return view('admin.article.edit')->withArticle($article)->withSorts(Sort::all())->withTags(Tag::all());
    }

    // 更新
    public function update(Request $request, $id)
    {
        // 数据验证
        $this->validate($request, [
            'title' => 'required|max:255', // 必填、在 articles 表中唯一、最大长度 255
            // 'body' => 'sometimes|nullable', // 必填
            'updated_at' => 'required|date_format:Y-m-d H:i:s', // 必填
        ]);
        // 通过 Article Model 插入一条数据进 articles 表
        $article = Article::find($id); // 初始化 Article 对象
        if (empty($article)) {
            return redirect('admin/article')->withErrors('指定的文章不存在！');
        }
        // 数据
        $article->sort_id = $request->get('sort_id', 0); // 分类id
        $article->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 article 的 title 属性
        $article->body = $request->get('body'); // 同上
        $article->excerpt = $request->get('excerpt'); // 同上
        $article->top = $request->get('top', 0); // 置顶
        $article->sorttop = $request->get('sorttop', 0); // 置顶
        $article->allow_remark = $request->get('allow_remark', 0); // 是否允许评论
        $article->hide = $request->get('hide', 0); //隐藏
        $article->updated_at = $request->get('updated_at');
        $request->has('pubdf') && $article->hide = 0; // 是否编辑的草稿箱发布
        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if ($article->save()) {
            // add Tag;
            $request->filled('tag') && $article->retag($request->get('tag'));
            if ($request->ajax()) {
                return response()->json(['status' => true, 'msg' => '保存成功！']);
            }
            return $request->has('back') ? redirect('admin/article/draft') : redirect('admin/article'); // 保存成功，跳转到 文章管理 页
        } else {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'msg' => '保存失败！']);
            }
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    // 自定义操作组
    public function actions(Request $request)
    {
        $this->validate($request, [
            'blog' => 'required|array',
            'sort_id' => 'sometimes|nullable|integer',
            'method' => 'required|alpha|in:del,hide,pub,top,sorttop,notop,sort',
        ]);
        // 获取请求操作
        $method = $request->get('method');
        // 获取需要操作的id列表
        $blog = array_map('intval', $request->get('blog'));
        switch ($method) {
            // 删除
            case 'del':
                $ArticleModel = Article::whereIn('id', $blog);
                $articles = $ArticleModel->get();
                DB::transaction(function () use ($articles, $ArticleModel) {
                    foreach ($articles as $article) {
                        $article->tagged()->delete();
                        $article->Comments()->delete();
                    }
                    $ArticleModel->delete();
                });
                return redirect()->back();
                break;
            // 隐藏
            case 'hide':
                if (Article::whereIn('id', $blog)->update(['hide' => 1])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('加入草稿箱失败！');
                }
                break;
            // 显示
            case 'pub':
                if (Article::whereIn('id', $blog)->update(['hide' => 0])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('显示失败！');
                }
                break;
            case 'top':
                if (Article::whereIn('id', $blog)->update(['top' => 1])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('首页置顶失败！');
                }
                break;
            case 'sorttop':
                if (Article::whereIn('id', $blog)->update(['sorttop' => 1])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('分类置顶失败！');
                }
                break;
            case 'notop':
                if (Article::whereIn('id', $blog)->update(['top' => 0, 'sorttop' => 0])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('取消置顶失败！');
                }
                break;
            case 'sort':
                $sort_id = $request->get('sort_id', 0);
                if (Article::whereIn('id', $blog)->update(['sort_id' => $sort_id])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('移动分类失败！');
                }
                break;
        }
    }

    // 删除
    public function destroy($id)
    {
        $article = Article::find($id);
        if (empty($article)) {
            return redirect('admin/article')->withErrors('指定的文章不存在！');
        }
        DB::transaction(function () use ($article) {
            $article->Comments()->delete();
            $article->tagged()->delete();
            $article->delete();
        });
        return redirect('admin/article');
    }
}
