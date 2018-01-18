@extends('layouts.admin')

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h4>管理中心</h4>
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
                <li role="presentation"><a href="{{ url('/admin/control') }}">基本设置</a></li>
                <li role="presentation" class="active"><a href="{{ url('/admin/control/seo') }}">SEO设置</a></li>
                <li role="presentation"><a href="{{ url('/admin/control/personal') }}">个人设置</a></li>
            </ul>
            <form action="{{ url('/admin/control/seo') }}" method="post" class="form-horizontal">
                {{ method_field('PUT') }}
                 <div class="alert alert-info">
                    你可以在这里修改文章链接的形式，如果修改后文章无法访问，那可能是你的服务器空间不支持URL重写，请修改回默认形式、关闭文章连接别名。
                    <br />启用链接别名后可以自定义文章和页面的链接地址。
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">链接设置</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="permalink" value="0" @if($_SITECONFIG['permalink'] == 0) checked="checked" @endif>默认形式：<span class="permalink_url">http://127.0.0.1/emlog6/?post=1</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="permalink" value="1" @if($_SITECONFIG['permalink'] == 1) checked="checked" @endif>文件形式：<span class="permalink_url">http://127.0.0.1/emlog6/post-1.html</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="permalink" value="2" @if($_SITECONFIG['permalink'] == 2) checked="checked" @endif>目录形式：<span class="permalink_url">http://127.0.0.1/emlog6/post/1</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="permalink" value="3" @if($_SITECONFIG['permalink'] == 3) checked="checked" @endif>分类形式：<span class="permalink_url">http://127.0.0.1/emlog6/category/1.html</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" style="vertical-align:middle;" value="1" name="isalias" id="isalias" @if($_SITECONFIG['isalias'] == 1) checked="checked" @endif/>启用文章链接别名
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" style="vertical-align:middle;" value="1" name="isalias_html" id="isalias_html" @if($_SITECONFIG['isalias_html'] == 1) checked="checked" @endif/>启用文章链接别名html后缀
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">META设置</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <span class="help-block">站点浏览器标题(title)</span>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input maxlength="200" class="form-control" value="{{ $_SITECONFIG['site_title'] }}" name="site_title" placeholder="如：秋风落叶" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <span class="help-block">站点关键字(keywords)</span>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input maxlength="200" class="form-control" value="{{ $_SITECONFIG['site_key'] }}" name="site_key" placeholder="如：秋风落叶 落叶 520"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <span class="help-block">站点浏览器描述(description)</span>
                                <div class="row">
                                    <div class="col-md-4">
                                        <textarea name="site_description" class="form-control" cols="" rows="4" placeholder="这是一段关于您网站的描述内容">{{ $_SITECONFIG['site_description'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-12">
                                <span class="help-block">文章浏览器标题方案</span>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="log_title_style" class="form-control">
                                            <option value="0" @if($_SITECONFIG['log_title_style'] == 0) selected="selected" @endif>文章标题</option>
                                            <option value="1" @if($_SITECONFIG['log_title_style'] == 1) selected="selected" @endif>文章标题 - 站点标题</option>
                                            <option value="2" @if($_SITECONFIG['log_title_style'] == 2) selected="selected" @endif>文章标题 - 站点浏览器标题</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-11 col-xs-12">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" value="保存设置" class="btn btn-primary" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('in');
    $("#menu_setting").addClass('active');
    </script>
</div>
@endsection