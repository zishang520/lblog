<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends BaseController
{
    // 列表
    public function index()
    {
        return view('admin.link.index')->withLinks(Link::orderBy('taxis', 'ASC')->get());
    }
    // 添加
    public function create()
    {
        return view('admin.link.create');
    }
    // 隐藏
    public function hide($id)
    {
        if (Link::where('id', $id)->update(['hide' => 1])) {
            return redirect('admin/link');
        } else {
            return redirect()->back()->withErrors('隐藏失败！');
        }
    }
    // 显示
    public function pub($id)
    {
        if (Link::where('id', $id)->update(['hide' => 0])) {
            return redirect('admin/link');
        } else {
            return redirect()->back()->withErrors('显示失败！');
        }
    }
    // 编辑
    public function edit($id)
    {
        $link = Link::find($id);
        if (empty($link)) {
            return redirect()->back()->withErrors('操作的友链不存在！');
        }
        return view('admin.link.edit')->withLink($link);
    }
    // 保存
    public function store(Request $request)
    {
        $this->validate($request, [
            'taxis' => 'bail|sometimes|nullable|integer',
            'sitename' => 'bail|required|max:128',
            'siteurl' => 'bail|required|unique:links|url|max:128',
            'hide' => 'bail|required|integer|in:0,1',
            'description' => 'sometimes|nullable|max:255',
        ]);

        $link = new Link;
        $link->sitename = $request->get('sitename');
        $link->siteurl = $request->get('siteurl');
        $link->taxis = $request->get('taxis', 0) ?: 0;
        $link->hide = $request->get('hide');
        $link->description = $request->get('description');

        if ($link->save()) {
            return redirect('admin/link');
        } else {
            return redirect()->back()->withInput()->withErrors();
        }
    }
    // 更新
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'taxis' => 'bail|sometimes|nullable|integer',
            'sitename' => 'bail|required|max:128',
            'siteurl' => 'bail|required|url|max:128',
            'hide' => 'bail|required|integer|in:0,1',
            'description' => 'sometimes|nullable|max:255',
        ]);
        $link = Link::find($id);
        if (empty($link)) {
            return redirect()->back()->withErrors('操作的友链不存在！');
        }
        $link->sitename = $request->get('sitename');
        $link->siteurl = $request->get('siteurl');
        $link->taxis = $request->get('taxis', 0) ?: 0;
        $link->hide = $request->get('hide');
        $link->description = $request->get('description');
        if ($link->save()) {
            return redirect('admin/link');
        } else {
            return redirect()->back()->withInput()->withErrors();
        }
    }

    // 排序
    public function taxis(Request $request)
    {
        $this->validate($request, [
            'link' => 'required|array',
        ]);
        $links = array_map('intval', $request->get('link'));
        // 怎么优化？？？？？暂时就这样吧，真垃圾
        foreach ($links as $key => $value) {
            Link::where('id', $key)->update(['taxis' => $value]);
        }
        return redirect('admin/link');
    }

    // 删除
    public function destroy($id)
    {
        $link = Link::find($id);
        if (empty($link)) {
            return redirect()->back()->withErrors('操作的友链不存在！');
        }
        if ($link->delete()) {
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors('删除失败！');
        }
    }
}
