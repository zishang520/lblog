@extends('layouts.admin')

@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>标签修改</h4>
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
                <div class="panel-heading">编辑分类</div>
                <div class="panel-body">
                    <form method="post" action="{{ url('/admin/tag/' . $tag->id) }}" class="form-horizontal">
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label class="col-sm-1 control-label">标签名</label>
                            <div class="col-sm-5">
                                <input size="40" value="{{ $tag->slug }}" name="slug" class="form-control" placeholder="新的标签名" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-5">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" value="保 存" class="btn btn-primary" />
                                <a class="btn btn-default" href="{{ url('/admin/tag') }}" />取 消</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $("#menu_tag").addClass('active');
    </script>
</div>

@endsection