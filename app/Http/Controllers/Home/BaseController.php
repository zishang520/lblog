<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Navbar;
use Illuminate\Support\Facades\Config;

class BaseController extends Controller
{
    public function __construct()
    {
        // 由于laravel5.3后，__construct比middleware优先执行，所以。。。。
        $this->middleware(function ($request, $next) {
            // 前台全局共享数据
            view()->share('_OPEN_WIDGETS', json_decode(Config::get('siteconfig.widgets'), true));
            view()->share('_WIDGETS', Config::get('widgets'));
            view()->share('_NAVBARS', Navbar::select('navname', 'type', 'depth', 'type_id', 'newtab', 'url')->where('hide', 0)->orderBy('taxis', 'ASC')->orderBy('lft', 'ASC')->orderBy('rgt', 'DESC')->get(['navname', 'type', 'depth', 'type_id', 'newtab', 'url']));
            return $next($request);
        });
    }
}
