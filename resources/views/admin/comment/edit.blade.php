@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>编辑评论</h4>
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
                <div class="panel-heading">编辑评论</div>
                <div class="panel-body">
                    <form action="{{ url('/admin/comment/' . $comment->id) }}" method="post" class="form-horizontal">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-md-1 control-label" for="exampleInputNickname1">昵称</label>
                            <div class="col-md-5">
                                <input type="text" name="nickname" class="form-control" id="exampleInputNickname1" value="{{ $comment->nickname }}" placeholder="昵称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label" for="exampleInputEmail1">邮箱</label>
                            <div class="col-md-5">
                                <input type="text" name="email" class="form-control" id="exampleInputEmail1" value="{{ $comment->email }}" placeholder="邮箱地址">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label" for="exampleInputWebsite1">网站</label>
                            <div class="col-md-5">
                                <input type="text" name="website" class="form-control" id="exampleInputWebsite1" value="{{ $comment->website }}" placeholder="网站地址">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-1 control-label" for="exampleInputContent1">内容</label>
                            <div class="col-md-5">
                                <textarea name="content" rows="5" cols="60" class="form-control" id="exampleInputContent1" placeholder="评论内容">{{ $comment->content }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-5">
                                <input type="submit" value="回复" class="btn btn-primary" />
                                <input type="button" value="取 消" class="btn btn-default" onclick="javascript: window.history.back();" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $("#menu_cm").addClass('active');
    </script>
</div>
@endsection