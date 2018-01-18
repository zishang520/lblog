<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>管理员登陆 - {{ $_SITECONFIG['site_title'] }}</title>
    <link type="text/css" href="{{ url('/l-admin/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ url('/l-admin/css/css-login.min.css') }}" rel="stylesheet" media="screen" />
    <script type="text/javascript" src="{{ url('/l-admin/js/jquery.min.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ url('/l-admin/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/l-admin/js/jquery.capslockstate.min.js') }}" charset="utf-8"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //登陆caps lock状态
            $(window).capslockstate().bind("capsOn", function(event) {
                if ($("#password:focus").length > 0) {
                    $("#password").popover('show');
                }
            }).bind("capsOff capsUnknown", function(event) {
                $('#password').popover('hide');
            });
            $("#password").bind("focusout", function(event) {
                $(this).popover('hide');
            }).bind("focusin", function(event) {
                if ($(window).capslockstate("state") === true) {
                    $(this).popover('show');
                }
            });
        });
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="modal fade in" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: block; position: initial;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">后台管理</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            <div class="form-group{{ $errors->has($_SITECONFIG['login_type']) ? ' has-error' : '' }}">
                                <label for="login" class="col-md-2 control-label">用户名</label>
                                <div class="col-md-9">
                                    <input id="login" type="{{ MakeLoginType($_SITECONFIG['login_type']) }}" class="form-control" name="{{ $_SITECONFIG['login_type'] }}" value="{{ old($_SITECONFIG['login_type']) }}" placeholder="用户名" autocomplete="off" required="required">
                                    @if ($errors->has($_SITECONFIG['login_type']))
                                        <span class="help-block">
                                            <strong>{{ $errors->first($_SITECONFIG['login_type']) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-2 control-label">密码</label>

                                <div class="col-md-9">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="密码" required="required" autocomplete="off" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Caps look已经点亮，注意区分大小写">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">验证码</label>
                                <div class="col-sm-9">
                                    <input type="text" name="imgcode" class="form-control" id="imgcode" placeholder="验证码" required="required" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <img src="../include/lib/checkcode.php" align="absmiddle" id="checkcode">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> 记住我
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-9">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-info">登陆</button>
                                    <button type="reset" class="btn btn-warning">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="../" class="btn btn-link btn-xs" role="button">返回首页</a>
                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-ext">
        </div>
    </div>
</body>

</html>
