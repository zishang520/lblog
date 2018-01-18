@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="{{ asset('/l-admin/css/cropper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/l-admin/css/sitelogo.min.css') }}">
    <script type="text/javascript" src="{{ asset('/l-admin/js/cropper.min.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('/l-admin/js/sitelogo.min.js') }}" charset="utf-8"></script>
@endsection
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>管理中心</h4>
                    </div>
                    <div class="col-lg-4">
                    @if (count($errors) > 0)
                        <span class="alert-close alert alert-danger fade in">
                            {!! implode('，', $errors->all()) !!}
                        </span>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs nav-tablist" role="tablist">
                <li role="presentation"><a href="{{ url('/admin/control') }}">基本设置</a></li>
                <li role="presentation"><a href="{{ url('/admin/control/seo') }}">SEO设置</a></li>
                <li role="presentation" class="active"><a href="{{ url('/admin/control/personal') }}">个人设置</a></li>
            </ul>
            <form action="{{ url('/admin/control/personal') }}" method="post" name="blooger" id="blooger" class="form-horizontal">
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="col-md-offset-1 col-sm-10" id="crop-avatar">
                        <span class="picture" title="点击修改头像">
                            <img src="{{ asset($user->photo) }}" class="img-thumbnail" alt="点击修改头像" style="cursor: pointer;"/>
                        </span>
                        <span class="help-block"><span class="text-info">点击图片修改头像，修改后将会自动保存</span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">昵称</label>
                    <div class="col-md-5">
                        <input maxlength="50" class="form-control" value="{{ $user->nickname }}" name="nickname" placeholder="您的昵称" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">个人描述</label>
                    <div class="col-md-5">
                        <textarea name="description" class="form-control" type="text" rows="4" maxlength="500" placeholder="描述一下自己吧">{{ $user->description }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">邮箱</label>
                    <div class="col-md-5">
                        <input name="email" class="form-control" value="{{ $user->email }}" maxlength="200" placeholder="您的邮箱,登陆时会使用"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">登陆名</label>
                    <div class="col-md-5">
                        <input maxlength="200" class="form-control" value="{{ $user->name }}" name="name" placeholder="登陆用户名"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-5">
                        <span class="help-block"><span class="text-warning">注意新修改的密码将于下次登陆时生效</span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">旧密码</label>
                    <div class="col-md-5">
                        <input type="password" minlength="6" maxlength="18" class="form-control" value="" name="oldpass" placeholder="请输入您的旧密码用于修改密码"/>
                        <span class="help-block">（不小于6位，不修改请留空）</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">新密码</label>
                    <div class="col-md-5">
                        <input type="password" minlength="6" maxlength="18" class="form-control" value="" name="newpass" placeholder="设置一个新的密码"/>
                        <span class="help-block">（不小于6位，不修改请留空）</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">新密码</label>
                    <div class="col-md-5">
                        <input type="password" minlength="6" maxlength="18" class="form-control" value="" name="repeatpass" placeholder="重复输入下您的新密码"/>
                        <span class="help-block">（再输入一次新密码）</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-1 col-sm-10">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="button" id="checkchangepass" value="保存资料" class="btn btn-primary" />
                    </div>
                </div>
                <div class="modal fade" id="RePassWord" tabindex="-1" role="dialog" aria-labelledby="RePassWordLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="RePassWordLabel">操作提示</h4>
                            </div>
                            <div class="modal-body">
                                <p class="bg-danger text-danger" style="padding: 15px;">您确认需要修改密码？修改密码后会自动退出。如需修改请牢记您的新密码，否则请置密码框为空</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消修改</button>
                                <input type="submit" class="btn btn-warning" value="保存资料" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg" style="top: 30px;">
            <div class="modal-content">
                <form class="avatar-form" action="{{ url('/admin/control/upphoto') }}" enctype="multipart/form-data" method="post">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>
                        <h4 class="modal-title" id="avatar-modal-label">上传个人头像</h4>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">
                            <div class="avatar-upload" style="display: inline-block;">
                                <input class="avatar-src" name="avatar_src" type="hidden">
                                <input class="avatar-data" name="avatar_data" type="hidden">
                                <label for="avatarInput" class="btn btn-default btn-sm"><i class="fa fa-upload fa-fw" aria-hidden="true"></i>图片上传
                                    <input class="avatar-input hidden" id="avatarInput" name="picture" type="file" accept="image/gif,image/jpeg,image/png,image/jpg,image/bmp">
                                </label>
                            </div>
                            <div class="alert-msg"></div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="avatar-wrapper"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="avatar-preview preview-lg"></div>
                                    <div class="avatar-preview preview-md"></div>
                                    <div class="avatar-preview preview-sm"></div>
                                </div>
                            </div>
                            <div class="row avatar-btns">
                                <div class="col-md-9">
                                    <div class="btn-group">
                                        <button class="btn" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees"><i class="fa fa-undo"></i> 向左旋转</button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees"><i class="fa fa-repeat"></i> 向右旋转</button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success btn-block avatar-save" type="submit" data-loading-text="保存中..." ><i class="fa fa-save"></i> 保存修改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('in');
        $("#menu_setting").addClass('active');

        $('#checkchangepass').click(function(){
            var $form = document.getElementById('blooger');
            if ($form.oldpass.value != '' && $form.newpass.value != '' && $form.repeatpass.value != '') {
                if ($form.newpass.value !== $form.repeatpass.value) {
                    ShowMsg('确认密码与新密码不一致！');
                    return false;
                }
                $('#RePassWord').modal('show');// 显示modal，提示确定需要修改密码
                return false;
            }
            return $form.submit();
        });
    });
    </script>
</div>
@endsection