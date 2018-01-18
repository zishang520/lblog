@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>页面管理</h4>
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
                <li role="presentation" class="active"><a href="{{ url('/admin/page') }}">页面管理</a></li>
                <li role="presentation"><a href="{{ url('/admin/page/create') }}">添加页面</a></li>
            </ul>
            <form action="{{ url('/admin/page/actions') }}" method="post" name="form_page" id="form_page">
                <table class="table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th width="461" colspan="2">标题</th>
                            <th width="140">模板</th>
                            <th width="50" class="tdcenter">评论</th>
                            <th width="140">时间</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if (!$pages->isEmpty())
                            @foreach ($pages as $page)
                            <tr>
                                <td width="21">
                                    <input type="checkbox" name="page[]" value="{{ $page->id }}" class="ids" />
                                </td>
                                <td width="440">
                                    <a href="{{ url('/admin/page/'.$page->id.'/edit') }}">{{ subString($page->title, 0, 40) }}</a>
                                    @if ($page->hide == 1)
                                    <span class="bg-danger text-danger"> [草稿] </span>
                                    @endif
                                </td>
                                <td></td>
                                <td class="tdcenter"><a href="{{ url('/admin/comment/artid_index/' . $page->id) }}">{{ $page->comments->count() }}</a></td>
                                <td class="small">{{ $page->created_at }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td class="tdcenter" colspan="5">还没有页面</td></tr>
                        @endif
                    </tbody>
                </table>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="method" id="method" value="">
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
            <div class="list_footer">
                <button type="button" class="btn btn-sm btn-success" id="select_all">全选</button>
                <label for="">选中项：</label>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModa2">删除</button>
                <button type="button" class="btn btn-sm btn-primary actions" data-actions="hide">转为草稿</button>
                 |
                <button type="button" class="btn btn-sm btn-info actions" data-actions="pub">发布</button>
            </div>
            <div class="page">{!! $pages->render() !!}</div>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        selectAllToggle();
        // 删除模态框
        $('#exampleModa2').on('show.bs.modal', function(){
            if(getChecked('ids') == false){
                ShowMsg('请选择你要操作的页面内容');
                return false;
            }
        });
        // 批量操作
        $('.actions').click(function(event) {
            if(getChecked('ids') == false){
                ShowMsg('请选择你要操作的页面内容');
                return false;
            }
            var actions = $(this).data('actions');
            var $form = $('#form_page');
            $form.find('#method').val(actions);
            $form.submit();
        });
    });
    $("#menu_page").addClass('active');
    </script>
</div>

@endsection