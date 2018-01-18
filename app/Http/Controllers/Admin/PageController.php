<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Article as Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends BaseController
{
    // 首页
    public function index()
    {
        return view('admin.page.index')->withPages(Page::where(['type' => 1])->with('Comments')->orderBy('id', 'DESC')->sharedLock()->paginate(10));
    }

    // 创建
    public function create()
    {
        return view('admin.page.create');
    }

    // 插入数据
    public function store(Request $request)
    {
        // 数据验证
        $this->validate($request, [
            'title' => 'required|max:255', // 必填、在 articles 表中唯一、最大长度 255
            // 'body' => 'sometimes', // 必填
        ]);
        // 通过 Page Model 插入一条数据进 articles 表
        $page = new Page; // 初始化 Page 对象
        // 数据
        $page->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 page 的 title 属性
        $page->body = $request->get('body'); // 同上
        $page->allow_remark = $request->get('allow_remark', 0); // 是否允许评论
        $page->hide = $request->get('hide', 0); //隐藏
        $page->user_id = $request->user()->id; // 获取当前 Auth 系统中注册的用户，并将其 id 赋给 article 的 user_id 属性
        $page->type = 1; //页面
        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if ($page->save()) {
            // add Tag;
            if ($request->ajax()) {
                return response()->json(['status' => true, 'msg' => '保存成功！', 'id' => $page->id]);
            }
            return redirect('admin/page'); // 保存成功，跳转到 文章管理 页
        } else {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'msg' => '保存失败！', 'id' => null]);
            }
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    // 编辑
    public function edit($id)
    {
        $page = Page::find($id);
        if (empty($page)) {
            return redirect('admin/page')->withErrors('查询页面数据不存在！');
        }
        return view('admin.page.edit')->withPage($page);
    }

    // 更新
    public function update(Request $request, $id)
    {
        // 数据验证
        $this->validate($request, [
            'title' => 'required|max:255', // 必填、在 articles 表中唯一、最大长度 255
            // 'body' => 'sometimes', // 必填
        ]);
        // 通过 Page Model 插入一条数据进 articles 表
        $page = Page::find($id); // 初始化 Page 对象
        if (empty($page)) {
            return redirect('admin/page')->withErrors('指定的文章不存在！');
        }
        // 数据
        $page->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 page 的 title 属性
        $page->body = $request->get('body'); // 同上
        $page->allow_remark = $request->get('allow_remark', 0); // 是否允许评论
        $page->hide = $request->get('hide', 0); //隐藏
        $page->user_id = $request->user()->id; // 获取当前 Auth 系统中注册的用户，并将其 id 赋给 article 的 user_id 属性
        $page->type = 1; //页面
        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if ($page->save()) {
            // add Tag;
            if ($request->ajax()) {
                return response()->json(['status' => true, 'msg' => '保存成功！']);
            }
            return redirect('admin/page'); // 保存成功，跳转到 文章管理 页
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
            'page' => 'bail|required|array',
            'sort_id' => 'bail|sometimes|nullable|integer',
            'method' => 'required|alpha|in:del,hide,pub,top,sorttop,notop,sort',
        ]);
        // 获取请求操作
        $method = $request->get('method');
        // 获取需要操作的id列表
        $page = array_map('intval', $request->get('page'));
        switch ($method) {
            // 删除
            case 'del':
                $PageModel = Page::whereIn('id', $page);
                $articles = $PageModel->get();
                DB::transaction(function () use ($articles, $PageModel) {
                    foreach ($articles as $article) {
                        $article->hasManyComments()->delete();
                    }
                    $PageModel->delete();
                });
                return redirect()->back();
                break;
            // 隐藏
            case 'hide':
                if (Page::whereIn('id', $page)->update(['hide' => 1])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('加入草稿箱失败！');
                }
                break;
            // 显示
            case 'pub':
                if (Page::whereIn('id', $page)->update(['hide' => 0])) {
                    return redirect()->back();
                } else {
                    return redirect()->back()->withErrors('显示失败！');
                }
                break;
        }
    }
}
