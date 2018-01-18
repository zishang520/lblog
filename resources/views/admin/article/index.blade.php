@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <!--文章内容-->
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>文章管理</h4>
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
                <li role="presentation" class="active"><a href="{{ $route['index'] }}">文章管理</a></li>
                <li role="presentation"><a href="{{ $route['draft'] }}">草稿管理</a></li>
            </ul>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="data_filter">
                        <label>
                            <select name="bysort" id="bysort" class="form-control input-sm">
                                <option value="">按分类查看...</option>
                                @if (!$sorts->isEmpty())
                                    @foreach ($sorts as $sort)
                                    <option value="{{ $sort->id }}"@if (isset($sortid) && $sortid == $sort->id) selected="selected"@endif>{{ $sort->sortname }}</option>
                                    @endforeach
                                @endif
                                <option value="0"@if (isset($sortid) && $sortid == 0) selected="selected"@endif>未分类</option>
                            </select>
                        </label>
                        <label>
                            <span><button type="button" class="btn btn-sm btn-info" id="f_t_tag">按标签查看</button></span>
                        </label>
                        <div class="well well-sm" id="well" style="display: none;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="zs-tag">
                                    @if (!$tags->isEmpty())
                                    @foreach ($tags as $tag)
                                        <li class="zs-tag-list">
                                            <label class="checkbox-inline">
                                                <span class="btn btn-xs btn-info tag-index" data-tag="{{ $tag->slug }}">{{ $tag->slug }}</span>
                                            </label>
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
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="data_filter text-right">
                        <form action="" method="get" accept-charset="utf-8" class="form-inline">
                            <div class="form-group">
                                <input type="text" name="keyword" class="form-control input-sm" placeholder="搜索文章">
                            </div>
                            <button type="submit" class="btn btn-default btn-sm">搜索</button>
                        </form>
                    </div>
                </div>
            </div>
            <form action="{{ url('/admin/article/actions') }}" method="post" name="form_log" id="form_log">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th width="511" colspan="2">标题</th>
                                <th width="50" class="tdcenter">查看</th>
                                <th width="100">作者</th>
                                <th width="146">分类</th>
                                <th width="130"><a href="./admin_log.php?sortDate=DESC">时间</a></th>
                                <th width="49" class="tdcenter"><a href="./admin_log.php?sortComm=ASC">评论</a></th>
                                <th width="59" class="tdcenter"><a href="./admin_log.php?sortView=ASC">阅读</a></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (!$articles->isEmpty())
                            @foreach ($articles as $article)
                            <tr>
                                <td width="21">
                                    <input type="checkbox" name="blog[]" value="{{ $article->id }}" class="ids" />
                                </td>
                                <td width="490">
                                    <a href="{{ url('/admin/article/'.$article->id.'/edit') }}">{{ subString($article->title, 0, 40) }}</a>
                                    @if ($article->top==1)
                                    <span class="label label-primary" title="首页置顶" style="cursor: pointer;">置顶</span>
                                    @endif
                                    @if ($article->sorttop==1)
                                    <span class="label label-info" title="分类置顶" style="cursor: pointer;">置顶</span>
                                    @endif
                                </td>
                                <td class="tdcenter">
                                    <a href="{{ url('/show/'.$article->id) }}" target="_blank" title="在新窗口查看">
                                        <i class="fa fa-external-link fa-fw"></i>
                                    </a>
                                </td>
                                <td><a href="{{ url('/admin/article/user_id/'.$article->user_id) }}">{{ $article->user->name }}</a></td>
                                <td><a href="./admin_log.php?sid=-1">未分类</a></td>
                                <td class="small">{{ $article->created_at }}</td>
                                <td class="tdcenter"><a href="{{ url('/admin/comment/artid_index/' . $article->id) }}">{{ $article->comments->count() }}</a></td>
                                <td class="tdcenter">{{ $article->reads }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td class="tdcenter" colspan="8">还没有文章</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="method" id="method" value="">
                <div class="list_footer form-inline">
                    <button type="button" class="btn btn-sm btn-success" id="select_all">全选</button>
                    <label for="">选中项：</label>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModa2">删除</button>
                    <button type="button" class="btn btn-sm btn-primary actions" data-actions="hide">放入草稿箱</button>
                     |
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            置顶操作 <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript: void(0);" class="actions" data-actions="top">首页置顶</a></li>
                            <li><a href="javascript: void(0);" class="actions" data-actions="sorttop">分类置顶</a></li>
                            <li class="divider"></li>
                            <li><a href="javascript: void(0);" class="actions" data-actions="notop">取消置顶</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <select name="sort_id" id="sort" class="form-control input-sm">
                            <option value="" selected="selected">移动到分类...</option>
                            @if (!$sorts->isEmpty())
                                @foreach ($sorts as $sort)
                                <option value="{{ $sort->id }}">{{ $sort->sortname }}</option>
                                @endforeach
                            @endif
                            <option value="0">未分类</option>
                        </select>
                    </div>
                </div>
                <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabe2">操作提示</h4>
                            </div>
                            <div class="modal-body">
                                <p class="bg-danger text-danger" style="padding: 15px;">该操作将会删除你选定的数据</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-danger actions" data-actions="del">删除</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="page">{!! $articles->render() !!}</div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            (function($){
                var status = true;
                $("#f_t_tag").click(function() {
                    if (status) {
                        status=false;
                        $("#well").fadeToggle(function(){
                            status = true;
                        });
                    }
                });
            })($);
            selectAllToggle();
            // 删除模态框
            $('#exampleModa2').on('show.bs.modal', function(){
                if(getChecked('ids') == false){
                    ShowMsg('请选择你要操作的日志');
                    return false;
                }
            });
            // 批量操作
            $('.actions').click(function(event) {
                if(getChecked('ids') == false){
                    ShowMsg('请选择你要操作的日志');
                    return false;
                }
                var actions = $(this).data('actions');
                var $form = $('#form_log');
                $form.find('#method').val(actions);
                $form.submit();
            });
            // 以分类查看内容
            $('#bysort').change(function() {
                var val = $(this).val();
                if(val != ''){
                    window.open('{{ url('/admin/article/sort_id_index') }}/' + val, '_self');
                }
            });
            // 根据标签显示文章
            $('.tag-index').click(function(event) {
                var val = $(this).data('tag');
                if(val != ''){
                    window.open('{{ url('/admin/article/tag_index') }}/' + val, '_self');
                }
            });
            // 分类
            $('#sort').on('change', function() {
                // 值不为空才继续执行
                if($(this).val() == ''){
                    return false;
                }
                if(getChecked('ids') == false){
                    ShowMsg('请选择你要操作的日志');
                    $(this).val(''); //清空选项
                    return false;
                }
                var $form = $('#form_log');
                $form.find('#method').val('sort');
                $form.submit();
            });
        });
        $("#menu_log").addClass('active');
    </script>
</div>
@endsection
