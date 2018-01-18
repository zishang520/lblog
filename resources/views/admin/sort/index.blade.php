@extends('layouts.admin')

@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>分类管理</h4>
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
            <ul class="nav nav-tabs nav-tablist" role="tablist" id="myTab">
                <li role="presentation" class="active"><a href="{{ url('/admin/sort') }}">分类管理</a></li>
                <li role="presentation"><a href="{{ url('/admin/sort/create') }}">添加分类</a></li>
            </ul>
            <form action="{{ url('/admin/sort/taxis') }}" method="post">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th width="55">序号</th>
                                <th width="160">名称</th>
                                <th width="180">描述</th>
                                <th width="130">别名</th>
                                <th width="100">模板</th>
                                <th width="40" class="tdcenter">查看</th>
                                <th width="40" class="tdcenter">文章</th>
                                <th width="60">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (!$sorts->isEmpty())
                            @foreach ($sorts as $sort)
                            <tr>
                                <td>
                                    <input class="form-control em-small input-sm" name="sort[{{ $sort->id }}]" value="{{ $sort->taxis }}" />
                                </td>
                                <td class="sortname">
                                    <a href="{{ url('/admin/sort/' . $sort->id . '/edit') }}">{{ str_repeat('- ', $sort->depth) . $sort->sortname }}</a>
                                </td>
                                <td>{{ $sort->description }}</td>
                                <td class="alias">{{ $sort->alias }}</td>
                                <td class="alias"></td>
                                <td class="tdcenter">
                                    <a href="http://127.0.0.1/emlog6/sort/1" target="_blank"><img src="/l-admin/images/vlog.gif" align="absbottom" border="0" /></a>
                                </td>
                                <td class="tdcenter"><a href="{{ url('/admin/article/sort_id_index/'. $sort->id) }}">{{ $sort->hasManyArticles->count() }}</a></td>
                                <td>
                                    <a href="{{ url('/admin/sort/' . $sort->id . '/edit') }}">编辑</a>
                                    <a href="#exampleModal" class="care" data-toggle="modal" data-target="#exampleModal" data-deleteurl="{{ url('/admin/sort/' . $sort->id) }}">删除</a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td class="tdcenter" colspan="8">还没有添加分类</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="list_footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" value="改变排序" class="btn btn-primary" />
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
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var deleteurl = button.data('deleteurl');
            $(this).find('.modal-content form').attr('action', deleteurl);
        });
        $("#menu_sort").addClass('active');
    });
    </script>
</div>

@endsection