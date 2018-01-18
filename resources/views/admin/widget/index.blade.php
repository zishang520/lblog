@extends('layouts.admin')

@section('head')
    <script type="text/javascript" src="{{ asset('/l-admin/js/jquery-ui.min.js') }}"></script>
@endsection

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-4">
                        <h4>侧边栏组件管理</h4>
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
        <div class="col-md-6" id="adm_widget_list">
            <div class="panel panel-default">
                <div class="panel-heading">
                    系统组件
                </div>
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                        {{-- <div id="BloggerWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseBlogger" aria-expanded="true" aria-controls="collapseBlogger">{{ $_WIDGET['BloggerWidget']['title'] }}</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                            </div>
                            <div class="BloggerWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseBlogger">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/BloggerWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['BloggerWidget']['title'] }}" placeholder="个人信息"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                        <div id="CalendarWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCalendar" aria-expanded="true" aria-controls="collapseCalendar">{{ $_WIDGET['CalendarWidget']['title'] }}</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                            </div>
                            <div class="CalendarWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseCalendar">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/CalendarWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['CalendarWidget']['title'] }}" placeholder="日历"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="TagWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTag" aria-expanded="true" aria-controls="collapseTag">{{ $_WIDGET['TagWidget']['title'] }}</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                            </div>
                            <div class="TagWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseTag">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/TagWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['TagWidget']['title'] }}" placeholder="标签"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="SortWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSort" aria-expanded="true" aria-controls="collapseSort">{{ $_WIDGET['SortWidget']['title'] }}</a>
                                    <li class="widget-act-add"></li>
                                    <li class="widget-act-del"></li>
                                </h4>
                            </div>
                            <div class="SortWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseSort">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/SortWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['SortWidget']['title'] }}" placeholder="分类"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="ArchiveWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseArchive" aria-expanded="true" aria-controls="collapseArchive">{{ $_WIDGET['ArchiveWidget']['title'] }}</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                            </div>
                            <div class="ArchiveWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseArchive">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/ArchiveWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['ArchiveWidget']['title'] }}" placeholder="归档"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="NewcommWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNewCom" aria-expanded="true" aria-controls="collapseNewCom">{{ $_WIDGET['NewcommWidget']['title'] }}</a>
                                    <li class="widget-act-add"></li>
                                    <li class="widget-act-del"></li>
                                </h4>
                            </div>
                            <div class="NewcommWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseNewCom">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/NewcommWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['NewcommWidget']['title'] }}" placeholder="最新评论">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">最新评论数</label>
                                            <input type="text" name="config[index_comnum]" maxlength="5" size="10" class="form-control" value="{{ $_WIDGET['NewcommWidget']['index_comnum'] }}" placeholder="最新评论数">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">新近评论截取字节数</label>
                                            <input type="text" name="config[comment_subnum]" maxlength="5" size="10" class="form-control" value="{{ $_WIDGET['NewcommWidget']['comment_subnum'] }}" placeholder="显示热门文章数">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="NewlogWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNewArt" aria-expanded="true" aria-controls="collapseNewArt">{{ $_WIDGET['NewlogWidget']['title'] }}</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                            </div>
                            <div class="NewlogWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseNewArt">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/NewlogWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['NewlogWidget']['title'] }}" placeholder="最新文章">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">显示最新文章数</label>
                                            <input type="text" name="config[index_newlog]" class="form-control" maxlength="5" size="10" value="{{ $_WIDGET['NewlogWidget']['index_newlog'] }}" placeholder="显示最新文章数">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="HotlogWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseHotArt" aria-expanded="true" aria-controls="collapseHotArt">{{ $_WIDGET['HotlogWidget']['title'] }}</a>
                                    <li class="widget-act-add"></li>
                                    <li class="widget-act-del"></li>
                                </h4>
                            </div>
                            <div class="HotlogWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseHotArt">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/HotlogWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['HotlogWidget']['title'] }}" placeholder="热门文章">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">显示热门文章数</label>
                                            <input type="text" name="config[index_hotlognum]" class="form-control" value="{{ $_WIDGET['HotlogWidget']['index_hotlognum'] }}" placeholder="显示热门文章数">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="LinkWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseLink" aria-expanded="true" aria-controls="collapseLink">{{ $_WIDGET['LinkWidget']['title'] }}</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                            </div>
                            <div class="LinkWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseLink">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/LinkWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['LinkWidget']['title'] }}" placeholder="链接"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="SearchWidget" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="widget-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSearch" aria-expanded="true" aria-controls="collapseSearch">{{ $_WIDGET['SearchWidget']['title'] }}</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                            </div>
                            <div class="SearchWidget panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapseSearch">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/SearchWidget') }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET['SearchWidget']['title'] }}" placeholder="搜索">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" value="更改" data-loading-text="保存中..." autocomplete="off" class="btn btn-primary">更改</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    自定义组件
                </div>
                <div class="panel-body">
                    <div class="panel-group" id="Myaccordion">
                        {{-- 遍历自定义组件 --}}
                        @if (!$widgets->isEmpty())
                            @foreach ($widgets as $widget)
                        <div id="{{ $widget->name }}" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="widget-title" role="button" data-toggle="collapse" data-parent="#Myaccordion" href="#collapse{{ $widget->name }}" aria-expanded="true" aria-controls="collapse{{ $widget->name }}">{{ $_WIDGET[$widget->name]['title'] }}</a>
                                <li class="widget-act-add"></li>
                                <li class="widget-act-del"></li>
                            </h4>
                            </div>
                            <div class="{{ $widget->name }} panel-collapse collapse" aria-expanded="false" role="tabpanel" id="collapse{{ $widget->name }}">
                                <div class="panel-body">
                                    <form action="{{ url('admin/widgets/' . $widget->name) }}" method="post" class="put-form">
                                        <div class="form-group">
                                            <label class="control-label">组件名称</label>
                                            <input type="text" name="config[title]" class="form-control" value="{{ $_WIDGET[$widget->name]['title'] }}" placeholder="组件名称">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">内容（支持html）</label>
                                            <textarea name="config[content]" class="form-control" rows="10" placeholder="内容 （支持html）">{{ $_WIDGET[$widget->name]['content'] }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="add" class="btn btn-primary" data-loading-text="保存中..." autocomplete="off">更改</button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-deleteurl="{{ url('/admin/widgets/' . $widget->id) }}">删除</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                            @endforeach
                        @endif
                        {{-- 遍历结束 --}}
                        <div class="form-group zs-margin">
                            <button type="button" class="btn btn-success" id="add_widgets">添加组件+</button>
                        </div>
                        <form action="{{ url('/admin/widgets') }}" method="post" name="custom_text_new" id="custom_text_new">
                            <div class="form-group">
                                <label class="control-label">组件名称</label>
                                <input type="text" name="config[title]" class="form-control" value="{{ old('title') }}" placeholder="组件名称">
                            </div>
                            <div class="form-group">
                                <label class="control-label">内容（支持html）</label>
                                <textarea name="config[content]" class="form-control" rows="10" placeholder="内容 （支持html）">{{ old('content') }}</textarea>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-primary">添加组件</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    使用中的组件
                </div>
                <form action="{{ url('admin/widgets/sort') }}" method="post">
                    <div class="panel-body">
                        <div class="panel-group adm_widget_box" id="sortable"></div>
                        <div class="form-group zs-margin">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-primary">保存组件排序</button>
                            <a href="" class="btn btn-danger">恢复出厂设置</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">操作提示</h4>
                        </div>
                        <div class="modal-body">
                            <p class="bg-danger text-danger" style="padding: 15px;">该操作将会删除你的数据</p>
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-danger">删除</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(document).ready(function() {
            (function(){
                var data = {!! $_SITECONFIG['widgets'] !!},
                    widget_element = data.map(function(item){
                        var title = $('#' + item).find('a.widget-title').text();
                        return '<div class="panel panel-default active_widget zs-cursor" id="zs_' + item + '"><div class="panel-heading"><input type="hidden" name="widgets[]" value="' + item + '" /><h4 class="panel-title">' + title + '</h4></div></div>';
                    });
                $(".adm_widget_box").append(widget_element);
            })();
            (function($){
                var status = true;
                $('#add_widgets').click(function(event) {
                    if (status) {
                        status = false;
                        $('#custom_text_new').fadeToggle(function() {
                            status = true;
                            $.cookie("zs_custom_text_new", $(this).css('display'), {
                                expires: 365
                            });
                        });
                    }
                });
            })($);
            var widgets = $(".active_widget").map(function() {
                return $(this).attr("id");
            });
            $.each(widgets, function(i, widget_id) {
                var widget_id = widget_id.substring(3);
                $("#" + widget_id + " .widget-act-add").hide();
                $("#" + widget_id + " .widget-act-del").show();
            });

            //添加组件
            $("#adm_widget_list .widget-act-add").click(function() {
                var title = $(this).prevAll(".widget-title").text();
                var widget_id = $(this).parent().parent().parent().attr("id");
                var widget_element = '<div class="panel panel-default active_widget zs-cursor" id="zs_' + widget_id + '"><div class="panel-heading"><input type="hidden" name="widgets[]" value="' + widget_id + '" /><h4 class="panel-title">' + title + '</h4></div></div>';
                $(".adm_widget_box").append(widget_element);
                $(this).hide();
                $(this).next(".widget-act-del").show();
            });
            //删除组件
            $("#adm_widget_list .widget-act-del").click(function() {
                var widget_id = $(this).parent().parent().parent().attr("id");
                $(".adm_widget_box #zs_" + widget_id).remove();
                $(this).hide();
                $(this).prev(".widget-act-add").show();
            });

            //拖动
            $("#sortable").sortable();
            $("#sortable").disableSelection();

            //自定义组件记忆
            $("#custom_text_new").css('display', $.cookie('zs_custom_text_new') ? $.cookie('zs_custom_text_new') : 'none');
            $("#menu_view").addClass('in');
            $("#menu_widget").addClass('active');
            // 删除一条数据或者对应ip
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var deleteurl = button.data('deleteurl');
                $(this).find('.modal-content form').attr('action', deleteurl);
            });
            // ajax提交
            $('form.put-form').submit(function(){
                var $this = $(this),
                    data = $this.serializeJSON(),
                    url = $this.attr('action');
                data._method = 'PUT';// 更新
                if(!(data.hasOwnProperty('config') && data.config.hasOwnProperty('title') && data.config.title)){
                    ShowMsg('组件名标不能为空');
                    return false;
                }
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $this.find('[name="add"]').button('loading');
                    },
                    success: function(d) {
                        var status = d.status ? 'text-success' : 'text-error';
                        ShowMsg('<span class="text ' + status + '">' + d.msg + '</span>', function(){
                            $this.find('[name="add"]').button('reset');
                        });
                    },
                    error: function(e) {
                        $this.find('[name="add"]').button('reset');
                        console.log(e);
                    }
                });
                return false;
            });
            $('form#custom_text_new').submit(function(){
                var data = $(this).serializeJSON();
                if(!(data.hasOwnProperty('config') && data.config.hasOwnProperty('title') && data.config.title)){
                    ShowMsg('组件名标不能为空');
                    return false;
                }
            });
        });
        </script>
    </div>
</div>
@endsection