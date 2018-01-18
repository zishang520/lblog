@extends('layouts.admin')

@section('head')
    @include('UEditor::head')
@endsection

@section('content')
<div id="page-wrapper">
    <div class="row">
        <!--页面内容-->
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>更新页面</h4>
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
        <form action="{{ url('/admin/page/'.$page->id) }}" method="post" id="addpage" name="addpage">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">更新页面</div>
                    <div class="panel-body">
                        <div id="post" class="form-group">
                            <div class="form-group">
                                <label>页面标题：</label>
                                <input type="text" name="title" id="title" value="{{ $page->title }}" class="form-control" placeholder="页面标题" />
                            </div>
                            <div class="form-group">
                                <label>页面内容：</label>
                                <textarea id="content" name="body" style="width:100%; height:460px;">{{ $page->body }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--页面侧边栏-->
            <div class="col-lg-4 container-side">
                <div class="panel panel-default">
                    <div class="panel-heading">设置项</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>链接别名：</label>
                            <input name="alias" id="alias" class="form-control" value="" />
                        </div>
                        <div class="form-group">
                            <label>访问密码：</label>
                            <input type="text" name="password" id="password" class="form-control" value="" />
                        </div>
                        <div class="form-group">
                            <input type="checkbox" value="1" name="allow_remark" id="allow_remark"@if($page->allow_remark == 1) checked="checked"@endif />
                            <label for="allow_remark">允许评论</label>
                        </div>
                    </div>
                </div>
                <div id="post_button">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="hide" value="{{ $page->hide }}">
                    <input type="submit" value="保存并返回" class="btn btn-primary" />
                    <input type="button" id="savedf" value="保存" data-loading-text="保存中..." class="btn btn-success" autocomplete="off" />
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#savedf').click(function(){
            var $this = this;
            if($('#title').val() == ''){
                ShowMsg('标题不能为空');
                return false;
            }
            var $form = $('#addpage');
            var data = $form.serializeJSON();
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
                        $form.append('{{ method_field("PUT") }}').attr('action', "{{ url('/admin/page') }}" + '/' + data.id)
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
        $('#addpage').submit(function(event) {
            if(this.title.value == ''){
                ShowMsg('标题不能为空');
                return false;
            }
        });
        UE.getEditor('content').ready(function() {
            this.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        })
        $("#menu_page").addClass('active');
    });
    </script>
</div>
@endsection