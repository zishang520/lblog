<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends BaseController
{
    // 列表
    public function index()
    {
        return view('admin.tag.index')->withTags(Tag::all());
    }

    // 编辑
    public function edit($id)
    {
        $tag = Tag::find($id);
        if (empty($tag)) {
            return redirect('admin/tag')->withErrors('指定的标签不存在！');
        }
        return view('admin.tag.edit')->withTag($tag);
    }

    // 更新
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'slug' => 'required|unique:tagging_tags',
        ]);
        $tag = Tag::find($id);
        if (empty($tag)) {
            return redirect('admin/tag')->withErrors('指定的标签不存在！');
        }
        $tagName = trim($request->get('slug'));

        $normalizer = config('tagging.normalizer');
        $normalizer = $normalizer ?: [static::$taggingUtility, 'slug'];

        // 获取处理后标签名
        $tagSlug = call_user_func($normalizer, $tagName);

        $displayer = config('tagging.displayer');
        $displayer = empty($displayer) ? '\Illuminate\Support\Str::title' : $displayer;
        DB::transaction(function () use ($tag, $displayer, $tagName, $tagSlug) {
            $tag->tagged()->update(['tag_name' => call_user_func($displayer, $tagName), 'tag_slug' => $tagSlug]);
            $tag->update(['name' => call_user_func($displayer, $tagName), 'slug' => $tagSlug]);
        });
        return redirect('admin/tag');
    }

    // 自定义操作
    public function actions(Request $request)
    {
        $this->validate($request, [
            'tag_id' => 'bail|required|array',
            'method' => 'required|alpha|in:del',
        ]);
        // 获取请求操作
        $method = $request->get('method');
        // 获取需要操作的id列表
        $tag_id = array_map('intval', $request->get('tag_id'));

        $TagModel = Tag::whereIn('id', $tag_id);
        $tags = $TagModel->get();
        DB::transaction(function () use ($tags, $TagModel) {
            foreach ($tags as $tag) {
                $tag->taggedhasOne()->delete();
            }
            $TagModel->delete();
        });
        return redirect()->back();
    }
}
