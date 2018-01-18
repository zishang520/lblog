<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>管理中心 - {{ $_SITECONFIG['blogname'] }}</title>
    <link type="text/css" href="{{ asset('/l-admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/l-admin/css/font-awesome.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/l-admin/css/css-main.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('/l-admin/js/jquery.min.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('/l-admin/js/plugin-cookie.min.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('/l-admin/js/bootstrap.min.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('/l-admin/js/main.js') }}" charset="utf-8"></script>

    @yield('head')

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-default navbar-static-top navbar-no-bottom" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url($_SITECONFIG['blogurl'] ?: '/') }}" target="_blank" title="在新窗口浏览站点">{{ $_SITECONFIG['blogname'] }}</a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li><a href="{{ url('/admin') }}"><i class="fa fa-home fa-fw"></i> 管理首页</a></li>
                    <li><a href="{{ url('/admin/control') }}"><i class="fa fa-wrench fa-fw"></i> 设置</a></li>
                    <li><a href="#LogOutMadal" data-toggle="modal" data-target="#LogOutMadal"><i class="fa fa-power-off fa-fw"></i> 退出</a></li>
                </ul>
            </nav>
        </div>
        <div class="row placeholder">
            <div class="col-md-2 col-sm-3">
                <div class="row">
                    <div class="sidebar" role="navigation" id="sidebar">
                        <div class="sidebar-nav navbar-collapse collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav" id="side-menu">
                                <li class="sidebar-avatar">
                                    <div class="text-center">
                                        <a href="{{ url('/admin/control/personal') }}">
                                            <img class="img-circle" src="{{ asset($_USERPHOTO) }}" />
                                        </a>
                                    </div>
                                </li>
                                <li><a href="{{ url('/admin/article/create') }}" id="menu_wt"><i class="fa fa-edit fa-fw"></i> 写文章</a></li>
                                <li><a href="{{ url('/admin/article') }}" id="menu_log"><i class="fa fa-list-alt fa-fw"></i> 文章</a></li>
                                <li><a href="{{ url('/admin/tag') }}" id="menu_tag"><i class="fa fa-tags fa-fw"></i> 标签</a></li>
                                <li><a href="{{ url('/admin/sort') }}" id="menu_sort"><i class="fa fa-flag fa-fw"></i> 分类</a></li>
                                <li><a href="{{ url('/admin/comment') }}" id="menu_cm"><i class="fa fa-comments fa-fw"></i> 评论{{ $_HIDEN_COM > 0 ? '('.$_HIDEN_COM.')' : '' }}</a></li>
                                <li><a href="{{ url('/admin/page') }}" id="menu_page"><i class="fa fa-file-o fa-fw"></i> 页面</a></li>
                                <li><a href="{{ url('/admin/link') }}" id="menu_link"><i class="fa fa-link fa-fw"></i> 友链</a></li>
                                <li id="menu_category_view">
                                    <a href="javascript:void(0)"><i class="fa fa-eye fa-fw"></i> 外观<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level collapse" id="menu_view">
                                        <li><a href="{{ url('/admin/widgets') }}" id="menu_widget"><i class="fa fa-columns fa-fw"></i> 侧边栏</a></li>
                                        <li><a href="{{ url('/admin/navbar') }}" id="menu_navi"><i class="fa fa-bars fa-fw"></i> 导航</a></li>
                                    </ul>
                                </li>
                                <li id="menu_category_sys">
                                    <a href="javascript:void(0)"><i class="fa fa-cog fa-fw"></i> 系统<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level collapse" id="menu_sys">
                                        <li><a href="{{ url('/admin/control') }}" id="menu_setting"><i class="fa fa-wrench fa-fw"></i> 设置</a></li>
                                        <li><a href="{{ url('/admin/user') }}" id="menu_user"><i class="fa fa-user fa-fw"></i> 用户</a></li>
                                        <li><a href="{{ url('/role/index') }}" id="menu_role"><i class="fa fa-users fa-fw"></i> 权限</a></li>
                                        <li><a href="data.php" id="menu_data"><i class="fa fa-database fa-fw"></i> 数据</a></li>
                                        {{-- <li><a href="plugin.php" id="menu_plug"><i class="fa fa-plug fa-fw"></i> 插件</a></li> --}}
                                        {{-- <li><a href="store.php" id="menu_store"><i class="fa fa-shopping-cart fa-fw"></i> 应用</a></li> --}}
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-sm-9">
                <div class="row my-border">
                    <div class="col-xs-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="footer">@zishang520</div>
            <div class="modal fade" id="LogOutMadal" tabindex="-1" role="dialog" aria-labelledby="LogOutMadalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="LogOutMadalLabel">操作提示</h4>
                        </div>
                        <div class="modal-body">
                            <p class="bg-danger text-danger" style="padding: 15px;">你确定要退出登陆？</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                            <a class="btn btn-danger" href="{{ url('/logout') }}" title="退出登陆">确定</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
