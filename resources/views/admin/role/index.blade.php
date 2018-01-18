@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-4">
                        <h4>权限管理</h4>
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
                <li role="presentation" class="active"><a href="{{ url('/admin/role') }}">权限管理</a></li>
                <li role="presentation"><a href="{{ url('/admin/role/create') }}">添加权限</a></li>
            </ul>
            <form action="comment.php-error_b=1.htm" method="post" name="form" id="form">
                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="adm_comment_list">
                    <thead>
                        <tr>
                            <th width="60"></th>
                            <th width="220"><b>权限</b></th>
                            <th width="250"><b>描述</b></th>
                            <th width="240"><b>电子邮件</b></th>
                            <th width="30" class="tdcenter"><b>文章</b></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </form>
            <div class="page"> (有1位权限)</div>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#adm_comment_list tbody tr:odd").addClass("tralt_b");
        $("#adm_comment_list tbody tr")
            .mouseover(function() {
                $(this).addClass("trover");
                $(this).find("span").show();
            })
            .mouseout(function() {
                $(this).removeClass("trover");
                $(this).find("span").hide();
            });
    });
    $("#menu_sys").addClass('in');
    $("#menu_role").addClass('active');
    </script>
</div>

@endsection
