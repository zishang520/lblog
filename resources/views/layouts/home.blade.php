<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
    <title>{{ $_SITECONFIG['site_title'] }}</title>
    <meta name="keywords" content="{{ $_SITECONFIG['site_key'] }}" />
    <meta name="description" content="{{ $_SITECONFIG['site_description'] }}" />
    <meta name="generator" content="zishang520" />
    <link rel="shortcut icon" href="{{ asset('/l-index/images/favicon.ico') }}" />
    <link href="{{ asset('/l-index/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/l-index/js/jquery-2.1.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/l-index/js/all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/l-index/js/common_tpl.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/l-index/js/m.js') }}" type="text/javascript"></script>
</head>

<body>
    <header id="header-web">
        <div class="header-main">
            <hgroup class="logo">
                <h1><a href="{{ url('/') }}" title="{{ $_SITECONFIG['site_title'] }}" rel="home"><img src="{{ url('/l-index/images/logo.png') }}" alt="{{ $_SITECONFIG['site_title'] }}"></a></h1>
                <h3>{{ $_SITECONFIG['site_description'] }}</h3>
            </hgroup>
            <!-- logo -->
            @if (!$_NAVBARS->isEmpty())
            <nav class="header-nav">
                <ul id="menu-nav" class="menu">
                    @foreach ($_NAVBARS as $navbar)
                    <li>
                        <a href="{{ NavbarUrl($navbar->type, $navbar->type_id, $navbar->url) }}"@if($navbar->newtab) target="_blank"@endif>{{ $navbar->navname }}</a>
                    </li>
                    @endforeach
                </ul>
            </nav>
            @endif
            <!-- header-nav -->
        </div>
    </header>
    <!--header-web-->
    <div id="main">

        @yield('container')

        <aside id="sitebar">
            {{-- 加载组件 --}}
            @if (is_array($_OPEN_WIDGETS))
                @foreach ($_OPEN_WIDGETS as $element)
                    @if ($_WIDGETS[$element]['isdefault'])
                        {{ Widget::run($element, $_WIDGETS[$element]) }}
                    @else
                        {{ Widget::run('DefaultWidget',$_WIDGETS[$element]) }}
                    @endif
                @endforeach
            @endif
            {{-- 加载组件 --}}
        </aside>
        <div class="clear"></div>
    </div>
    <!--end #content-->
    <footer id="footer-web">
        <div class="about">
            <div class="right">
                <ul id="menu-bottom-nav" class="menu">
                    <li>
                        <a href="/tags.php" title="网站标签页" target="_blank">网站标签</a>
                    </li>
                </ul>
                <p class="banquan">{{ $_SITECONFIG['site_description'] }}</p>
            </div>
            <div class="left">
                <ul class="bottomlist">
                    <li>
                        <a href="#0" class="cd-popup-trigger"><img src="{{ url('/l-index/images/phone.png') }}" alt="web app"></a>
                    </li>
                </ul>
                <div class="cd-popup">
                    <div class="cd-popup-container">
                        <h1>扫描二维码，手机访问{{ $_SITECONFIG['site_title'] }}</h1>
                        <img src="{{ asset('/l-index/images/myinfo.png') }}" alt="扫一扫我吧">
                        <a href="#" class="cd-popup-close"></a>
                    </div>
                    <!-- cd-popup-container -->
                </div>
                <!-- cd-popup -->
            </div>
        </div>
        <!--about-->
        <div class="bottom">
            All Powered By <a href="http://www.luoyy.com" target="_blank">win紫殇</a>
        </div>
        <!--bottom-->
        <!-- 返回顶部 -->
        <div class="onlineService" id="back-to-top">
            <a href="javascript:void(0);" class="totop">Up</a>
        </div>
    </footer>
</body>

</html>
