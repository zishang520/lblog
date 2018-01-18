@extends('layouts.admin')

@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-2">
                        <h4>添加分类</h4>
                    </div>
                    <div class="col-lg-10">
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
            <ul class="nav nav-tabs nav-tablist" role="tablist" id="myTab">
                <li role="presentation"><a href="{{ url('/admin/sort') }}">分类管理</a></li>
                <li role="presentation" class="active"><a href="{{ url('/admin/sort/create') }}">添加分类</a></li>
            </ul>
            <form action="{{ url('/admin/sort') }}" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-1 control-label">序号</label>
                    <div class="col-md-2">
                        <input type="number" maxlength="4" name="taxis" class="form-control" placeholder="序号" value="{{ old('taxis') }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">名称</label>
                    <div class="col-md-5">
                        <input class="form-control" name="sortname" id="sortname" required="required" placeholder="名称" value="{{ old('sortname') }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">别名</label>
                    <div class="col-md-5">
                        <input class="form-control" name="alias" id="alias" placeholder="别名" value="{{ old('alias') }}" />
                        <p class="help-block">用于URL的友好显示</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">父分类</label>
                    <div class="col-md-5">
                        <select name="parent_id" id="parent_id" class="form-control" placeholder="父分类">
                            <option value="">无</option>
                            @if (!$sorts->isEmpty())
                            @foreach ($sorts as $sort)
                            <option value="{{ $sort->id }}"@if (old('parent_id') == $sort->id) selected="selected"@endif>{{ str_repeat('- ', $sort->depth) . $sort->sortname }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">模板</label>
                    <div class="col-md-5">
                        <input class="form-control" name="template" id="template" value="{{ old('template') }}" placeholder="模板" />
                        <p class="help-block">用于自定义分类页面模板，对应模板目录下.php文件，默认为log_list.php</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">分类描述</label>
                    <div class="col-md-5">
                        <textarea name="description" type="text" class="form-control" rows="5" placeholder="分类描述">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-5">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" id="addsort" value="添加新分类" class="btn btn-primary" /><span id="alias_msg_hook"></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $("#menu_sort").addClass('active');
    </script>
</div>

@endsection