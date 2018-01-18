@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>更新导航</h4>
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
                <div class="panel-heading">更新导航</div>
                <div class="panel-body">
                    <form action="{{ url('/admin/navbar/' . $navbar->id) }}" method="post" class="form-horizontal">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label class="col-md-1 control-label">序号</label>
                            <div class="col-md-2">
                                <input type="number" maxlength="4" name="taxis" class="form-control" placeholder="序号" value="{{ $navbar->taxis }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label">名称</label>
                            <div class="col-md-5">
                                <input class="form-control" name="navname" id="navname" required="required" placeholder="导航名称" value="{{ $navbar->navname }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label">当前状态</label>
                            <div class="col-md-5">
                                <select name="hide" class="form-control">
                                    <option value="0"@if ($navbar->hide == 0) selected="selected" @endif>显示</option>
                                    <option value="1"@if ($navbar->hide == 1) selected="selected" @endif>隐藏</option>
                                </select>
                            </div>
                        </div>
                        @if($navbar->type == 0)
                        <div class="form-group">
                            <label class="col-md-1 control-label">地址</label>
                            <div class="col-md-5">
                                <input class="form-control" name="url" id="url" required="required" placeholder="导航地址(带http://或https://)" value="{{ $navbar->url }}" />
                            </div>
                        </div>
                        @if ($navbar->isLeaf())
                        <div class="form-group">
                            <label class="col-md-1 control-label">父级</label>
                            <div class="col-md-5">
                                <select name="parent_id" class="form-control">
                                    <option value="">无</option>
                                    @if (!$navbars->isEmpty())
                                    @foreach ($navbars as $value)
                                    <option value="{{ $value->id }}"@if ($navbar->parent_id == $value->id) selected="selected"@endif>{{ str_repeat('- ', $value->depth) . $value->navname }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endif
                        @endif
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-5">
                                <div class="checkbox">
                                    <label class="control-label">
                                        <input type="checkbox" name="newtab" value="1" @if($navbar->newtab == 1) checked="checked" @endif> 在新窗口打开
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-5">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" id="addnavbar" value="更新导航" class="btn btn-primary" /><span id="alias_msg_hook"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('in');
        $("#menu_navi").addClass('active');
    });
    </script>
</div>
@endsection