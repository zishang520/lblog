@extends('layouts.admin')

@section('head')
    <link type="text/css" href="{{ asset('/l-admin/css/bootstrap-tagsinput.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('/l-admin/js/bootstrap-tagsinput.min.js') }}" charset="utf-8"></script>
    @include('UEditor::head')
@endsection

@section('content')
<div id="page-wrapper">
    <div class="row">
        <!--文章内容-->
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>发布文章</h4>
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
        <form action="{{ url('/admin/article') }}" method="post" id="addlog" name="addlog">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">发布文章</div>
                    <div class="panel-body">
                        <div id="post" class="form-group">
                            <div class="form-group">
                                <label>文章标题：</label>
                                <input type="text" name="title" id="title" required="required" value="{{ old('title') }}" class="form-control" placeholder="文章标题" />
                            </div>
                            <div class="form-group">
                                <label>文章内容：</label>
                                <textarea id="content" name="body" style="width:100%; height:460px;">{{ old('body') }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-info" id="adv">高级选项</button>
                            </div>
                            <div id="advset">
                                <div class="form-group">
                                    <label>文章摘要：</label>
                                        <textarea id="excerpt" name="excerpt" style="width:100%; height:260px;">{{ old('excerpt') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--文章侧边栏-->
            <div class="col-lg-4 container-side">
                <div class="panel panel-default">
                    <div class="panel-heading">设置项</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>选择分类：</label>
                            <select name="sort_id" id="sort_id" class="form-control">
                                <option value="0">选择分类...</option>
                                @if (!$sorts->isEmpty())
                                    @foreach ($sorts as $sort)
                                    <option value="{{ $sort->id }}"@if (old('sort_id') == $sort->id) selected="selected"@endif>{{ $sort->sortname }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>标签：</label>
                            <input name="tag" id="tag" class="form-control" value="{{ old('title') }}" placeholder="文章标签，使用逗号分隔" />
                        </div>
                        <div class="form-group">
                            <label><button type="button" class="btn btn-warning btn-sm" id="tag-insert">已有标签+</button></label>
                            <div class="panel panel-info" id="tag-list" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="zs-tag">
                                        @if (!$tags->isEmpty())
                                        @foreach ($tags as $tag)
                                            <li class="zs-tag-list">
                                                <span class="btn btn-xs btn-default add-tag">{{ $tag->slug }}</span>
                                            </li>
                                        @endforeach
                                        @else
                                            <li class="zs-tag-list">
                                                暂时还没有标签
                                            </li>
                                        @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>发布时间：</label>
                            <input maxlength="200" name="updated_at" id="updated_at" value="{{ old('title')?:date('Y-m-d H:i:s') }}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>链接别名：</label>
                            <input name="alias" id="alias" class="form-control" value="" />
                        </div>
                        <div class="form-group">
                            <label>访问密码：</label>
                            <input type="text" name="password" id="password" class="form-control" value="" />
                        </div>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" value="1" name="top" id="top"@if(old('top') == 1) checked="checked"@endif />首页置顶
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="1" name="sorttop" id="sorttop"@if(old('sorttop') == 1) checked="checked"@endif />分类置顶
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="1" name="allow_remark" id="allow_remark" checked="checked" />允许评论
                            </label>
                        </div>
                    </div>
                </div>
                <div id="post_button">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" value="发布文章" class="btn btn-primary" />
                    <input type="button" id="savedf" value="保存草稿" data-loading-text="保存中..." class="btn btn-success" autocomplete="off" />
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#tag').tagsinput({
            maxChars: 8,
            trimValue: true
        });
        $('.add-tag').click(function(event) {
            $('#tag').tagsinput('add', $(this).text());
        });
        $('.bootstrap-tagsinput input').focus(function(){
            $(this).parent().addClass('focus');
        }).blur(function(){
            $(this).parent().removeClass('focus');
        });
        (function($){
            var status = true;
            $('#tag-insert').click(function(event) {
                if (status) {
                    status = false;
                    $('#tag-list').fadeToggle(function() {
                        status = true;
                    });
                }
            });
        })($);
        $('#savedf').click(function(){
            var $this = this;
            if($('#title').val() == ''){
                ShowMsg('标题不能为空');
                return false;
            }
            var $form = $('#addlog');
            var data = $form.serializeJSON();
            data.hide = 1;// 隐藏
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $($this).button('loading');
                },
                success: function(data) {
                    // 判断是否有返回id，有的话修改请求地址为更新
                    if (data.status && data.id) {
                        $form.append('{{ method_field("PUT") }}').attr('action', "{{ url('/admin/article') }}" + '/' + data.id)
                    }
                    var status = data.status ? 'text-success' : 'text-error';
                    ShowMsg('<span class="text ' + status + '">' + data.msg + '</span>', 3000);
                    $($this).button('reset');
                },
                error: function(e) {
                    $($this).button('reset');
                    console.log(e);
                }
            });
        });
        $('#addlog').submit(function(event) {
            if(this.title.value == ''){
                ShowMsg('标题不能为空');
                return false;
            }
        });
        UE.getEditor('content').ready(function() {
            this.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        }),
        UE.getEditor('excerpt').ready(function() {
            this.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        });
        $("#menu_wt").addClass('active');
        $("#advset").css('display', $.cookie('advset') ? $.cookie('advset') : '');
    });
    </script>
</div>

@endsection