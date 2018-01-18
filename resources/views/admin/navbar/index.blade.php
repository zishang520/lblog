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
                <li role="presentation" class="active"><a href="{{ url('/admin/navbar') }}">导航管理</a></li>
                <li role="presentation"><a href="{{ url('/admin/navbar/create') }}">添加导航</a></li>
            </ul>
            <form action="{{ url('/admin/navbar/taxis') }}" method="post">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th width="50">序号</th>
                                <th width="230">导航</th>
                                <th width="60" class="tdcenter">类型</th>
                                <th width="60" class="tdcenter">状态</th>
                                <th width="50" class="tdcenter">查看</th>
                                <th width="360">地址</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$navbars->isEmpty())
                            @foreach ($navbars as $navbar)
                            <tr>
                                <td>
                                    <input class="form-control em-small input-sm" name="navbar[{{ $navbar->id }}]" value="{{ $navbar->taxis }}" maxlength="4" />
                                </td>
                                <td><a href="{{ url('/admin/navbar/' . $navbar->id . '/edit') }}" title="修改导航">{{ str_repeat('- ', $navbar->depth) . $navbar->navname }}</a></td>
                                <td class="tdcenter">
                                    <span class="text-primary">{!! NavbarType($navbar->type) !!}</span>
                                </td>
                                <td class="tdcenter">
                                    @if ($navbar->hide == 0)
                                        <a href="{{ url('/admin/navbar/' . $navbar->id . '/hide') }}" title="点击隐藏链接" class="text-primary">显示</a>
                                    @else
                                        <a href="{{ url('/admin/navbar/' . $navbar->id . '/pub') }}" title="点击显示链接" class="text-danger">隐藏</a>
                                    @endif
                                </td>
                                <td class="tdcenter">
                                    <a href="{{ NavbarUrl($navbar->type, $navbar->type_id, $navbar->url) }}" target="_blank" title="查看链接">
                                        <img src="{{ url('/l-admin/images/vlog2.gif') }}" align="absbottom" border="0" />
                                    </a>
                                </td>
                                <td>{{ NavbarUrl($navbar->type, $navbar->type_id, $navbar->url) }}</td>
                                <td>
                                    <a href="{{ url('/admin/navbar/' . $navbar->id . '/edit') }}">编辑</a>
                                    @if($navbar->isdefault == 0)
                                    {{-- <a href="javascript:void(0);" class="care notdel">删除</a> --}}
                                    {{-- @else --}}
                                    <a href="#exampleModal" class="care" data-toggle="modal" data-target="#exampleModal" data-deleteurl="{{ url('/admin/navbar/' . $navbar->id) }}">删除</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
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
        $('.notdel').click(function(event) {
             ShowMsg('系统导航不能删除！');
        });
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('in');
        $("#menu_navi").addClass('active');
    });
    </script>
</div>
@endsection
