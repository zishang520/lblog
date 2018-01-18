<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/**
 * 所有ID都在Route服务提供商中做了过滤
 */
// 报错路由
Route::get('errors/{type}', 'ErrorsController@index');

// 前台路由
Route::group(['namespace' => 'Home'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('show/{id}', 'IndexController@show');
    Route::post('comment', 'CommentController@store');
});

//认证路由
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@Login');
    Route::get('logout', 'LoginController@logout');
});

// 后台路由
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::get('/', 'HomeController@index'); //后台首页

    // 文章路由组
    Route::group(['prefix' => 'article'], function () {
        Route::post('actions', 'ArticleController@actions'); //自定义操作
        Route::get('sort_id_index/{id}/{action?}', 'ArticleController@sort_id_index'); //根据分类显示文章
        Route::get('user/{id}/{action?}', 'ArticleController@user'); //根据用户显示文章
        Route::get('tag_index/{tag}/{action?}', 'ArticleController@tag_index'); //根据分类显示文章
        Route::get('draft', 'ArticleController@draft'); //查看草稿箱
    });
    Route::resource('article', 'ArticleController', ['except' => ['show']]); //文章管理

    // 评论路由组
    Route::group(['prefix' => 'comment'], function () {
        Route::get('index/{action?}', 'CommentController@index'); //查看评论
        Route::get('artid_index/{id}/{action?}', 'CommentController@artid_index'); //根据文章显示评论
        Route::delete('del_ip/{ip}', 'CommentController@del_ip'); //根据IP删除评论
        Route::post('actions', 'CommentController@actions'); //自定义操作
        Route::get('{id}/replay', 'CommentController@replay'); //回复评论
        Route::get('{id}/hide', 'CommentController@hide'); //隐藏评论
        Route::get('{id}/pub', 'CommentController@pub'); //审核评论
    });
    Route::resource('comment', 'CommentController', ['except' => ['show']]); //评论管理

    // 分类管理
    Route::group(['prefix' => 'sort'], function () {
        Route::post('taxis', 'SortController@taxis');
    });
    Route::resource('sort', 'SortController', ['except' => ['show']]); // 分类管理

    // 标签路由
    Route::group(['prefix' => 'tag'], function () {
        Route::post('actions', 'TagController@actions'); //自定义批量操作
    });
    Route::resource('tag', 'TagController', ['only' => ['index', 'edit', 'update']]); // 标签资源路由

    // 单页路由
    Route::group(['prefix' => 'page'], function () {
        Route::post('actions', 'PageController@actions'); //自定义批量操作
    });
    Route::resource('page', 'PageController', ['except' => ['show']]); // 单页资源路由

    // 友链路由
    Route::group(['prefix' => 'link'], function () {
        Route::get('{id}/hide', 'LinkController@hide'); //隐藏
        Route::get('{id}/pub', 'LinkController@pub'); //显示
        Route::post('taxis', 'LinkController@taxis'); //排序
    });
    Route::resource('link', 'LinkController', ['except' => ['show']]); // 友链资源路由

    // 后台设置
    Route::group(['prefix' => 'control'], function () {
        Route::get('/', 'ControlController@index');
        Route::put('/', 'ControlController@indexput');
        Route::get('seo', 'ControlController@seo');
        Route::put('seo', 'ControlController@seoput');
        Route::get('personal', 'ControlController@personal');
        Route::put('personal', 'ControlController@personalput');
        Route::post('upphoto', 'ControlController@upphoto');
    });

    // 分类管理
    Route::group(['prefix' => 'navbar'], function () {
        Route::get('{id}/hide', 'NavbarController@hide'); //隐藏
        Route::get('{id}/pub', 'NavbarController@pub'); //显示
        Route::post('taxis', 'NavbarController@taxis'); // 排序
        Route::post('add', 'NavbarController@add'); // 添加单页
    });
    Route::resource('navbar', 'NavbarController', ['except' => ['show']]);

    // 用户管理
    Route::resource('user', 'UserController', ['except' => ['show']]); // 用户管理
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@index'); //排序
    });
    // widgets
    Route::group(['prefix' => 'widgets'], function () {
        Route::post('sort', 'WidgetsController@sort'); //排序
    });
    // widgets
    Route::resource('widgets', 'WidgetsController', ['except' => ['show']]);
});
