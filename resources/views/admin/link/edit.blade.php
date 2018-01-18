@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>更新友链</h4>
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
            <div class="panel panel-default">
                <div class="panel-heading">更新友链</div>
                <div class="panel-body">
                    <form action="{{ url('/admin/link/' . $link->id) }}" method="post" class="form-horizontal">
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label class="col-md-1 control-label">序号</label>
                            <div class="col-md-2">
                                <input type="number" maxlength="4" name="taxis" class="form-control" placeholder="序号" value="{{ $link->taxis }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label">名称</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="sitename" id="sitename" required="required" placeholder="名称" value="{{ $link->sitename }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label">地址</label>
                            <div class="col-md-5">
                                <input type="url" class="form-control" name="siteurl" id="siteurl" required="required" placeholder="地址" value="{{ $link->siteurl }}" />
                                <p class="help-block"><sapn class="text-danger">必填*</sapn>，友情链接URL</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label">当前状态</label>
                            <div class="col-md-5">
                                <select name="hide" class="form-control">
                                    <option value="0"@if ($link->hide == 0) selected="selected" @endif>显示</option>
                                    <option value="1"@if ($link->hide == 1) selected="selected" @endif>隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label">友链描述</label>
                            <div class="col-md-5">
                                <textarea name="description" type="text" class="form-control" rows="5" placeholder="友链描述">{{ $link->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-5">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" id="addsort" value="更新友链" class="btn btn-primary" /><span id="alias_msg_hook"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#menu_link").addClass('active');
    </script>
</div>
@endsection