<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    public function index()
    {
        $gd_ver = function_exists("imagecreate") ? (function_exists('gd_info') ? gd_info()['GD Version'] : '支持') : '不支持';
        return view('admin.home')
            ->with('_GD_VERSION', $gd_ver)
            ->with('_DB', ['version' => Cache::remember('_DB', Config::get('cache.ttl', 60), function () {
                return Db::select("SELECT VERSION() as version")[0]->version;
            }), 'name' => ucwords(Config::get('database.default'))])
            ->with('artcount', Article::all()->count())
            ->with('comcount', Comment::all()->count());
    }
}
