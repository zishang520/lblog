<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Article as Page;
use App\Models\Navbar;
use App\Models\Sort;
use Illuminate\Http\Request;

class NavbarController extends BaseController
{
    /**
     * [index 首页]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2016-12-07T15:06:24+0800
     * @copyright (c)                      ZiShang520    All Rights Reserved
     * @return    [type]                   [description]
     */
    public function index()
    {
        return view('admin.navbar.index')->withNavbars(Navbar::orderBy('taxis', 'ASC')->orderBy('lft', 'ASC')->orderBy('rgt', 'DESC')->get());
    }

    // 隐藏
    public function hide($id)
    {
        if (Navbar::where('id', $id)->update(['hide' => 1])) {
            return redirect('admin/navbar');
        } else {
            return redirect()->back()->withErrors('隐藏失败！');
        }
    }
    // 显示
    public function pub($id)
    {
        if (Navbar::where('id', $id)->update(['hide' => 0])) {
            return redirect('admin/navbar');
        } else {
            return redirect()->back()->withErrors('显示失败！');
        }
    }

    /**
     * [create 添加新导航]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2016-12-07T15:06:31+0800
     * @copyright (c)                      ZiShang520    All Rights Reserved
     * @return    [type]                   [description]
     */
    public function create()
    {
        return view('admin.navbar.create')
            ->withNavbars(Navbar::whereNotNull('depth')
                    ->orderBy('taxis', 'ASC')
                    ->orderBy('lft', 'ASC')
                    ->orderBy('rgt', 'DESC')
                    ->get())
            ->withSorts(Sort::orderBy('lft', 'ASC')
                    ->orderBy('rgt', 'DESC')
                    ->get())
            ->withPages(Page::where(['type' => 1, 'hide' => 0])
                    ->orderBy('id', 'DESC')
                    ->sharedLock()
                    ->get());
    }
    // 编辑
    public function edit($id)
    {
        $navbar = Navbar::find($id);
        if (empty($navbar)) {
            return redirect()->back()->withErrors('操作的友链不存在！');
        }
        $view = view('admin.navbar.edit')->withNavbar($navbar);
        if ($navbar->type == 0) {
            return $view->withNavbars($navbar->getNotSelfAndChilds());
        }
        return $view;
    }

    /**
     * [store 保存新导航]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2016-12-07T15:06:46+0800
     * @copyright (c)                      ZiShang520 All           Rights Reserved
     * @param     Request                  $request   [description]
     * @return    [type]                              [description]
     */
    public function store(Request $request)
    {
        // 数据验证
        $this->validate($request, [
            'taxis' => 'bail|sometimes|nullable|integer',
            'navname' => 'bail|required|max:25',
            'url' => 'bail|sometimes|nullable|url',
            'parent_id' => 'bail|sometimes|nullable|integer|exists:navbars,id',
            'hide' => 'bail|required|integer|in:0,1',
            'newtab' => 'sometimes|nullable|in:1',
        ]);

        $navbar = new Navbar;
        $navbar->taxis = $request->get('taxis', 0) ?: 0; // 排序
        $navbar->navname = $request->get('navname'); // 导航栏名称
        $navbar->url = $request->get('url'); // 导航栏地址
        $navbar->parent_id = $request->get('parent_id') ?: null; //导航栏腹肌节点
        $navbar->hide = $request->get('hide', 0); //是否显示
        $navbar->newtab = $request->get('newtab', 0); //导航栏是否新窗口打开
        // $navbar->type = 4; //导航栏类型
        $navbar->parent_id || $navbar->NavbarIsRoot(); //是否是顶级
        if ($navbar->save()) {
            return redirect('admin/navbar');
        } else {
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }
    public function update(Request $request, $id)
    {
        // 数据验证
        $this->validate($request, [
            'taxis' => 'bail|sometimes|nullable|integer',
            'navname' => 'bail|required|max:25',
            'url' => 'bail|sometimes|nullable|url',
            'parent_id' => 'bail|sometimes|nullable|integer|exists:navbars,id',
            'hide' => 'bail|required|integer|in:0,1',
            'newtab' => 'sometimes|nullable|in:1',
        ]);

        $navbar = Navbar::find($id);
        if (empty($navbar)) {
            return redirect()->back()->withErrors('操作的导航不存在！');
        }

        $navbar->taxis = $request->get('taxis', 0) ?: 0; // 排序
        $navbar->navname = $request->get('navname'); // 导航栏名称
        $navbar->hide = $request->get('hide', 0); //是否显示
        $navbar->newtab = $request->get('newtab', 0); //导航栏是否新窗口打开
        if ($navbar->type == 0) {
            $navbar->url = $request->get('url'); // 导航栏地址
            $navbar->parent_id = $request->get('parent_id') ?: null; //导航栏腹肌节点
            // $navbar->type = 0; //导航栏类型
            $navbar->parent_id || $navbar->NavbarIsRoot(); //是否是顶级
        }
        if ($navbar->save()) {
            return redirect('admin/navbar');
        } else {
            return redirect()->back()->withInput()->withErrors('更新失败！');
        }
    }

    // 添加分类或者单页
    public function add(Request $request)
    {
        $this->validate($request, [
            'action' => 'required|alpha|in:page,sort',
            'pages' => 'sometimes|array',
            'sorts' => 'sometimes|array',
        ]);

        switch ($request->get('action')) {
            case 'page':
                $pages = $request->get('pages', []);
                if (Navbar::addNavbar($pages, 4)) {
                    return redirect('admin/navbar');
                } else {
                    return redirect()->back()->withErrors('添加失败！');
                }
                break;
            case 'sort':
                $sorts = $request->get('sorts', []);
                if (Navbar::addNavbar($sorts, 3)) {
                    return redirect('admin/navbar');
                } else {
                    return redirect()->back()->withErrors('添加失败！');
                }
                break;
        }
    }

    // 排序
    public function taxis(Request $request)
    {
        $this->validate($request, [
            'navbar' => 'required|array',
        ]);
        $navbars = array_map('intval', $request->get('navbar'));
        // 怎么优化？？？？？暂时就这样吧，真垃圾
        foreach ($navbars as $key => $value) {
            Navbar::where('id', $key)->update(['taxis' => $value]);
        }
        return redirect('admin/navbar');
    }

    // 删除
    public function destroy($id)
    {
        $navbar = Navbar::find($id);
        if (empty($navbar)) {
            return redirect()->back()->withErrors('操作的友链不存在！');
        }
        if ($navbar->isdefault == 1) {
            return redirect()->back()->withErrors('系统导航不能删除！');
        }
        if ($navbar->delete()) {
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors('删除失败！');
        }
    }
}
