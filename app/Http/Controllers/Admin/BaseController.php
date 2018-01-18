<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function __construct()
    {
        // 由于laravel5.3后，__construct比middleware优先执行，所以。。。。
        $this->middleware(function ($request, $next) {
            // 后台全局共享数据
            view()->share('_USERPHOTO', Auth::user()->photo);
            view()->share('_HIDEN_COM', Comment::where('hide', 1)
                    ->count());
            return $next($request);
        });
    }
}
