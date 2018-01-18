<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Control;
use App\Models\Widgets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class WidgetsController extends BaseController
{
    /**
     * [index 组件列表]
     * @Author    ZiShang520@gmail.com
     * @DateTime  2017-02-13T16:52:58+0800
     * @copyright (c)                      ZiShang520    All Rights Reserved
     * @return    [type]                   [description]
     */
    public function index()
    {
        return view('admin.widget.index')->with('_WIDGET', Config::get('widgets'))->withWidgets(Widgets::where(['isdefault' => 0])->orderBy('id', 'ASC')->get(['id', 'name']));
    }

    // 添加
    public function store(Request $request)
    {
        $this->validate($request, [
            'config' => 'sometimes|nullable|array',
        ]);
        $widgets = new Widgets;
        $widgets->name = uniqid();
        $widgets->value = json_encode($request->get('config') ?: []);
        if ($widgets->save()) {
            $widgets->SaveConfig(); // 保存到本地
            if ($request->ajax()) {
                return response()->json(['status' => true, 'msg' => '保存成功！']);
            }
            return redirect('admin/widgets'); // 保存成功，跳转到 文章管理 页
        } else {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'msg' => '保存失败！']);
            }
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    // 更新
    public function update(Request $request, $name)
    {
        $this->validate($request, [
            'config' => 'required|array',
        ]);
        $widgets = Widgets::where(['name' => $name])->first(); // 初始化 Article 对象
        if (empty($widgets)) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'msg' => '指定的组件不存在！']);
            }
            return redirect('admin/widgets')->withErrors('指定的组件不存在！');
        }
        $widgets->value = json_encode($request->get('config') ?: []);
        if ($widgets->save()) {
            $widgets->SaveConfig(); // 保存到本地
            if ($request->ajax()) {
                return response()->json(['status' => true, 'msg' => '保存成功！']);
            }
            return redirect('admin/widgets'); // 保存成功，跳转到 文章管理 页
        } else {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'msg' => '保存失败！']);
            }
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    // 排序
    public function sort(Request $request)
    {
        $this->validate($request, [
            'widgets' => 'sometimes|nullable|array',
        ]);
        $widgets = $request->get('widgets', []);
        if (is_array($widgets)) {
            $Control = Control::updateOrCreate(['option_name' => 'widgets'], ['option_value' => json_encode($widgets)]);
            if ($Control->SaveConfig()) {
                return redirect('admin/widgets');
            } else {
                return redirect()->back()->withErrors('保存失败！');
            }
        } else {
            return redirect()->back();
        }
    }

    // 删除自定义组件
    public function destroy($id)
    {
        $widget = Widgets::where(['id' => $id, 'isdefault' => 0])->first();
        if (empty($widget)) {
            return redirect('admin/widgets')->withErrors('指定的组件不存在！');
        }
        $open_widgets = json_decode(Config::get('siteconfig.widgets'), true);
        // 最佳性能
        $new_open_widgets = [];
        if (is_array($open_widgets)) {
            $new_open_widgets = array_diff($open_widgets, [$widget->name]);
        }
        DB::transaction(function () use ($widget, $new_open_widgets) {
            Control::updateOrCreate(['option_name' => 'widgets'], ['option_value' => json_encode($new_open_widgets)])->SaveConfig();
            $widget->delete() && $widget->SaveConfig();
        });
        return redirect('admin/widgets');
    }
}
