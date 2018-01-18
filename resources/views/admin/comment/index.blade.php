@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>评论管理</h4>
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
                <li role="presentation"@if ($type=='index') class="active"@endif><a href="{{ $Urls['all'] }}">全部评论</a></li>
                <li role="presentation"@if ($type=='hide') class="active"@endif><a href="{{ $Urls['hide'] }}">未审核 <span class="badge">{{ $hide_num }}</span></a></li>
                <li role="presentation"@if ($type=='pub') class="active"@endif><a href="{{ $Urls['pub'] }}">已审核</a></li>
            </ul>
            <form action="{{ url('/admin/comment/actions') }}" method="post" name="form_com" id="form_com">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="adm_comment_list">
                        <thead>
                            <tr>
                                <th width="369" colspan="2">内容</th>
                                <th width="300">评论者</th>
                                <th width="250">所属文章</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (!$comments->isEmpty())
                            @foreach ($comments as $comment)
                            <tr>
                                <td width="19">
                                    <input type="checkbox" value="{{ $comment->id }}" name="com[]" class="ids" />
                                </td>
                                <td width="350"><a href="{{ url('/admin/comment/' . $comment->id . '/replay') }}" title="{{ $comment->content }}">{{ subString($comment->content, 0, 40) }}</a>
                                    <p>
                                        {{ $comment->created_at }}
                                        @if ($comment->hide==1)
                                        <span class="bg-danger text-danger"> [待审] </span>
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    @if ($comment->website)
                                        <a href="{{ $comment->website }}" target="_blank">{{ $comment->nickname }}</a>
                                    @else
                                        <a href="javascript:void(0);">{{ $comment->nickname }}</a>
                                    @endif
                                    ({{ $comment->email }})
                                    <br />来自：{{ $comment->ip }} <a href="#exampleModal" data-toggle="modal" data-target="#exampleModal" data-deleteurl="{{ url('/admin/comment/del_ip/' . $comment->ip) }}" title="删除来自该IP的所有评论" class="care">(X)</a>
                                    <span style="display:none; margin-left:8px;" class="operating">
                                        <a href="#exampleModal" class="care" data-toggle="modal" data-target="#exampleModal" data-deleteurl="{{ url('/admin/comment/' . $comment->id) }}">删除</a>
                                        @if ($comment->hide==1)
                                        <a href="{{ url('/admin/comment/' . $comment->id . '/pub') }}">审核</a>
                                        @else
                                        <a href="{{ url('/admin/comment/' . $comment->id . '/hide') }}">隐藏</a>
                                        @endif
                                        <a href="{{ url('/admin/comment/' . $comment->id . '/replay') }}">回复</a>
                                        <a href="{{ url('/admin/comment/' . $comment->id . '/edit') }}">编辑</a>
                                    </span>
                                </td>
                                <td><a href="{{ url('/article/'.$comment->Article->id) }}" target="_blank" title="查看该文章">{{ $comment->Article->title }}</a></td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td class="tdcenter" colspan="4">还没有收到评论</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="list_footer">
                    <button type="button" class="btn btn-sm btn-success" id="select_all">全选</button>
                    <label for="">选中项：</label>
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModa2">删除</button>
                    <button type="button" class="btn btn-sm btn-primary actions" data-actions="hide">隐藏</button>
                    <button type="button" class="btn btn-sm btn-info actions" data-actions="pub">审核</button>
                    <input name="method" id="method" value="" type="hidden" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="page">{!! $comments->render() !!}</div>
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
        selectAllToggle();
        $("#adm_comment_list tbody tr:odd").addClass("tralt_b");
        $("#adm_comment_list tbody tr").mouseover(function() {
            $(this).addClass("trover");
            $(this).find("span.operating").show();
        }).mouseout(function() {
            $(this).removeClass("trover");
            $(this).find("span.operating").hide();
        });
        // 删除一条数据或者对应ip
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var deleteurl = button.data('deleteurl');
            $(this).find('.modal-content form').attr('action', deleteurl);
        });
        // 删除模态框
        $('#exampleModa2').on('show.bs.modal', function(){
            if(getChecked('ids') == false){
               ShowMsg('请选择你要操作的评论');
                return false;
            }
        });
        // 批量操作
        $('.actions').click(function(event) {
            if(getChecked('ids') == false){
               ShowMsg('请选择你要操作的评论');
                return false;
            }
            var actions = $(this).data('actions');
            var $form = $('#form_com');
            $form.find('#method').val(actions);
            $form.submit();
        });
        // 选中左边菜单
        $("#menu_cm").addClass('active');
    });
    </script>
</div>
@endsection