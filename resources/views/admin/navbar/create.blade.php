@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-4">
                        <h4>导航管理</h4>
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
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs nav-tablist" role="tablist" id="myTab">
                <li role="presentation"><a href="{{ url('/admin/navbar') }}">导航管理</a></li>
                <li role="presentation" class="active"><a href="{{ url('/admin/navbar/create') }}">添加导航</a></li>
            </ul>
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            添加自定义导航
                        </div>
                        <div class="panel-body" id="admindex_servinfo">
                            <form action="{{ url('/admin/navbar') }}" method="post" name="navi" id="navi">
                                <div class="form-group">
                                    <label class="control-label">序号</label>
                                    <input type="number" maxlength="4" name="taxis" class="form-control" placeholder="序号" value="{{ old('taxis') }}" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">导航名称</label>
                                    <input type="text" name="navname" class="form-control" value="{{ old('navname') }}" required="required" placeholder="导航名称">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">导航地址</label>
                                    <input type="url" name="url" class="form-control" value="{{ old('url') }}" required="required" placeholder="导航地址(带http://或https://)">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">父级导航</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">无</option>
                                        @if (!$navbars->isEmpty())
                                        @foreach ($navbars as $navbar)
                                        <option value="{{ $navbar->id }}"@if (old('parent_id') == $navbar->id) selected="selected"@endif>{{ str_repeat('- ', $navbar->depth) . $navbar->navname }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">当前状态</label>
                                    <select name="hide" class="form-control">
                                        <option value="0"@if (old('hide') == 0) selected="selected" @endif>显示</option>
                                        <option value="1"@if (old('hide') == 1) selected="selected" @endif>隐藏</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label class="control-label">
                                            <input type="checkbox" name="newtab" value="1" @if(old('newtab') == 1) checked="checked" @endif> 在新窗口打开
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-primary">添加</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            添加分类到导航
                        </div>
                        <div class="panel-body" id="admindex_servinfo">
                            <form action="{{ url('/admin/navbar/add') }}" method="post" name="navi" id="navi">
                                @if (!$sorts->isEmpty())
                                @foreach ($sorts as $sort)
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label class="control-label">
                                            <input type="checkbox" style="vertical-align:middle;" name="sorts[{{ $sort->id }}]" value="{{ $sort->sortname }}" class="ids"> {{ str_repeat('- ', $sort->depth) . $sort->sortname }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="form-group">
                                    <div class="checkbox">
                                        暂时还没有分类可以添加
                                    </div>
                                </div>
                                @endif
                                <input type="hidden" name="action" value="sort">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-primary">添加</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            添加页面到导航
                        </div>
                        <div class="panel-body" id="admindex_servinfo">
                            <form action="{{ url('/admin/navbar/add') }}" method="post" name="navi" id="navi">
                                @if (!$pages->isEmpty())
                                @foreach ($pages as $page)
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label class="control-label">
                                            <input type="checkbox" style="vertical-align:middle;" name="pages[{{ $page->id }}]" value="{{ $page->title }}" class="ids"> {{ $page->title }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="form-group">
                                    <div class="checkbox">
                                        暂时还没有页面可以添加
                                    </div>
                                </div>
                                @endif
                                <input type="hidden" name="action" value="page">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-primary">添加</button>
                            </form>
                        </div>
                    </div>
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
