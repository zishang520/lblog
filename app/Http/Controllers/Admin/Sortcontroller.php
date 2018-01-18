<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Sort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SortController extends BaseController
{
    // 分类
    public function index()
    {
        return view('admin.sort.index')->withSorts(Sort::with('hasManyArticles')->orderBy('taxis', 'ASC')->orderBy('lft', 'ASC')->orderBy('rgt', 'DESC')->get());
    }

    // 添加
    public function create()
    {
        return view('admin.sort.create')->withSorts(Sort::orderBy('taxis', 'ASC')->orderBy('lft', 'ASC')->orderBy('rgt', 'DESC')->get());
    }

    // 编辑
    public function edit($id)
    {
        $sort = Sort::find($id);
        if (empty($sort)) {
            return redirect('admin/sort')->withErrors('指定的分类不存在！');
        }
        return view('admin.sort.edit')->withSort($sort)->withSorts($sort->getNotSelfAndChilds());
    }

    // 保存
    public function store(Request $request)
    {
        $this->validate($request, [
            'taxis' => 'bail|sometimes|nullable|integer',
            'sortname' => 'bail|required|unique:sorts|max:25',
            'alias' => 'bail|sometimes|nullable|alpha_num',
            'parent_id' => 'bail|sometimes|nullable|integer|exists:sorts,id',
            'description' => 'sometimes|nullable|max:255',
        ]);

        $sort = new Sort;
        $sort->taxis = $request->get('taxis', 0) ?: 0;
        $sort->sortname = $request->get('sortname');
        $sort->alias = $request->get('alias', '');
        $sort->parent_id = $request->get('parent_id') ?: null;
        $sort->description = $request->get('description');
        $sort->parent_id || $sort->SortIsRoot(); //是否是顶级
        if ($sort->save()) {
            return redirect('admin/sort');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    // 更新
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'taxis' => 'bail|sometimes|nullable|integer',
            'sortname' => 'bail|required|max:25',
            'alias' => 'bail|sometimes|nullable|alpha_num',
            'parent_id' => 'bail|sometimes|nullable|integer|exists:sorts,id',
            'description' => 'sometimes|nullable|max:255',
        ]);

        $sort = Sort::find($id);
        if (empty($sort)) {
            return redirect('admin/sort')->withErrors('指定的分类不存在！');
        }
        $sort->taxis = $request->get('taxis', 0) ?: 0;
        $sort->sortname = $request->get('sortname');
        $sort->alias = $request->get('alias', '');
        $sort->parent_id = $request->get('parent_id') ?: null;
        $sort->description = $request->get('description');
        $sort->parent_id || $sort->SortIsRoot(); //是否是顶级
        if ($sort->save()) {
            return redirect('admin/sort');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    // 排序
    public function taxis(Request $request)
    {
        $this->validate($request, [
            'sort' => 'required|array',
        ]);
        $sorts = array_map('intval', $request->get('sort'));
        // 怎么优化？？？？？暂时就这样吧，真垃圾
        foreach ($sorts as $key => $value) {
            Sort::where('id', $key)->update(['taxis' => $value]);
        }
        return redirect('admin/sort');
    }

    // 删除
    public function destroy($id)
    {
        $sort = Sort::find($id);
        if (empty($sort)) {
            return redirect()->back()->withErrors('操作的分类不存在！');
        }
        DB::transaction(function () use ($sort) {
            $sort->hasManyArticles()->update(['sort_id' => 0]);
            $sort->delete();
        });
        return redirect()->back();
    }
}
