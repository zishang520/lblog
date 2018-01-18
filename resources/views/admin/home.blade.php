@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-4">
                        <h4>后台首页</h4>
                    </div>
                    <div class="col-md-4">
                    @if (count($errors) > 0)
                        <span class="alert-close alert alert-danger fade in">
                            {!! implode('，', $errors->all()) !!}
                        </span>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-laptop fa-fw"></i> 站点信息
                </div>
                <div class="panel-body" id="admindex_servinfo">
                    <div class="row">
                        <ul class="col-md-12">
                            <li>有<b>{{ $artcount }}</b>篇文章，<b>{{ $comcount }}</b>条评论</li>
                            <li>PHP版本：{{ PHP_VERSION }}</li>
                            <li>数据库：{{ $_DB['name'] }} - {{ $_DB['version'] }}</li>
                            <li>服务器环境：{{ $_SERVER['SERVER_SOFTWARE'] }}</li>
                            <li>GD图形处理库：{{ $_GD_VERSION }}</li>
                            <li>服务器空间允许上传最大文件：{{ ini_get('upload_max_filesize') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-volume-down fa-fw"></i> 官方消息
                </div>
                <div class="panel-body" id="admindex_msg">
                    <div class="row">
                        <ul class="col-md-12"><span class="ajax_remind_1">我是520</span></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div id="admindex">
                <div id="about" class="alert alert-warning">
                  欢迎使用 © zs-Blog v1.0.0-Beta
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
