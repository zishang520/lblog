@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>回复评论</h4>
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
                <div class="panel-heading">回复评论</div>
                <div class="panel-body">
                    <p>评论人：{{ $comment->nickname }}</p>
                    <p>时间：{{ $comment->created_at }}</p>
                    <p>内容：{{ $comment->content }}</p>
                    <form action="{{ url('/admin/comment/') }}" method="post" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-5">
                                <textarea name="content" rows="5" cols="60" class="form-control" placeholder="回复评论" required="required"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="article_id" value="{{ $comment->article_id }}">
                        <input type="hidden" value="4" name="cid" />
                        <input type="hidden" value="n" name="hide" />
                        <div class="form-group">
                            <div class="col-md-5">
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