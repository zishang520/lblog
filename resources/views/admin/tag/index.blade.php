@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>标签管理</h4>
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
                <div class="panel-heading">标签管理</div>
                <div class="panel-body">
                    <form action="{{ url('/admin/tag/actions') }}" method="post" name="form_tag" id="form_tag">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="zs-tag">
                                @if (!$tags->isEmpty())
                                @foreach ($tags as $tag)
                                    <li class="zs-tag-list">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="tag_id[]" class="ids" value="{{ $tag->id }}">
                                            <a href="{{ url('/admin/tag/' . $tag->id . '/edit') }}" class="btn btn-xs">{{ $tag->slug }}</a>
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
                        <hr>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="method" id="method" value="">
                        <div class="list_footer form-inline">
                            <button type="button" class="btn btn-sm btn-success" id="select_all">全选</button>
                            <label for="">选中项：</label>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModa2">删除</button>
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
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    selectAllToggle();
    // 删除模态框
    $('#exampleModa2').on('show.bs.modal', function(){
        if(getChecked('ids') == false){
            ShowMsg('请选择你要操作的标签');
            return false;
        }
    });
    $('.zs-tag .zs-tag-list a').each(function() {
        var btn = ['btn-default', 'btn-info', 'btn-success', 'btn-primary', 'btn-danger', 'btn-warning'];
        $(this).addClass(btn[parseInt(Math.random()*100%(btn.length))]);
    });
    // 批量操作
    $('.actions').click(function(event) {
        if(getChecked('ids') == false){
            ShowMsg('请选择你要操作的标签');
            return false;
        }
        var actions = $(this).data('actions');
        var $form = $('#form_tag');
        $form.find('#method').val(actions);
        $form.submit();
    });
    $("#menu_tag").addClass('active');
    </script>
</div>
@endsection