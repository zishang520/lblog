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
                <li role="presentation" class="active"><a href="{{ url('/admin/control') }}">基本设置</a></li>
                <li role="presentation"><a href="{{ url('/admin/control/seo') }}">SEO设置</a></li>
                <li role="presentation"><a href="{{ url('/admin/control/personal') }}">个人设置</a></li>
            </ul>
            <form action="{{ url('/admin/control') }}" method="post" name="input" id="input" class="form-horizontal">
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label class="col-md-1 control-label">站点标题</label>
                    <div class="col-md-4">
                        <input class="form-control" value="{{ $_SITECONFIG['blogname'] }}" name="blogname" placeholder="如：秋风落叶" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">副标题</label>
                    <div class="col-md-4">
                        <textarea name="bloginfo" rows="3" class="form-control" placeholder="如：秋风落叶">{{ $_SITECONFIG['bloginfo'] }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">站点地址</label>
                    <div class="col-md-4">
                        <input class="form-control" value="{{ $_SITECONFIG['blogurl'] }}" name="blogurl" placeholder="如：http://www.luoyy.com"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="detect_url" id="detect_url" @if($_SITECONFIG['detect_url'] == 1) checked="checked" @endif/>自动检测站点地址 (可能和部分CDN解决方案不兼容)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">分页设置</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-xs-2 text-auto text-left-padding">
                                <p class="form-control-static">每页显示</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                                <input maxlength="5" class="form-control" value="{{ $_SITECONFIG['index_lognum'] }}" name="index_lognum" placeholder="如：10"/>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">篇文章</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">所在时区</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-xs-6 text-left-padding">
                                <select name="timezone" class="form-control">
                                    @if(isset($timezone) && is_array($timezone))
                                    @foreach ($timezone as $key => $value)
                                        <option value="{{ $key }}" @if($_SITECONFIG['timezone'] == $key) selected="selected" @endif>{{ $value }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <p class="form-control-static">(本地时间：{{ date('Y-m-d H:i:s') }})</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">登陆设置</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-xs-2 text-auto text-left-padding">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="login_code" id="login_code" @if($_SITECONFIG['login_code'] == 1) checked="checked" @endif/>登录验证码
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-1 text-auto text-padding">
                                <p class="form-control-static">，使用</p>
                            </div>
                            <div class="col-xs-2 text-auto">
                                <select name="login_type" class="form-control">
                                    <option value="email" @if($_SITECONFIG['login_type'] == 'email') selected="selected" @endif>邮箱</option>
                                    <option value="name" @if($_SITECONFIG['login_type'] == 'name') selected="selected" @endif>用户名</option>
                                </select>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">作为登陆名</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">摘要设置</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-xs-2 text-auto text-left-padding">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="isexcerpt" id="isexcerpt" @if($_SITECONFIG['isexcerpt'] == 1) checked="checked" @endif/>自动摘要，
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-1 text-auto text-padding">
                                <p class="form-control-static">截取前</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                                <input class="form-control" value="{{ $_SITECONFIG['excerpt_subnum'] }}" name="excerpt_subnum" placeholder="如：10"/>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">个字作为摘要</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">RSS设置</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-xs-2 text-auto text-left-padding">
                                <p class="form-control-static">RSS输出</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                                <input maxlength="5" value="{{ $_SITECONFIG['rss_output_num'] }}" class="form-control" name="rss_output_num" placeholder="如：10"/>
                            </div>
                            <div class="col-xs-3 text-auto text-padding">
                                <p class="form-control-static">篇文章（0为关闭），且输出</p>
                            </div>
                            <div class="col-xs-2 text-auto">
                                <select name="rss_output_fulltext" class="form-control">
                                    <option value="1" @if($_SITECONFIG['rss_output_fulltext'] == 1) selected="selected" @endif>全文</option>
                                    <option value="0" @if($_SITECONFIG['rss_output_fulltext'] == 0) selected="selected" @endif>摘要</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">评论设置</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-xs-2 text-auto text-left-padding">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="iscomment" id="iscomment" @if($_SITECONFIG['iscomment'] == 1) checked="checked" @endif/>开启评论
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">，发表评论间隔</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                                <input maxlength="5" class="form-control" value="{{ $_SITECONFIG['comment_interval'] }}" name="comment_interval" placeholder="如：10"/>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">秒</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 text-auto">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="ischkcomment" id="ischkcomment" @if($_SITECONFIG['ischkcomment'] == 1) checked="checked" @endif/>评论审核
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 text-auto">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="comment_code" id="comment_code" @if($_SITECONFIG['comment_code'] == 1) checked="checked" @endif/>评论验证码
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 text-auto">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="isgravatar" id="isgravatar" @if($_SITECONFIG['isgravatar'] == 1) checked="checked" @endif/>评论人头像
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 text-auto">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="comment_needchinese" id="comment_needchinese" @if($_SITECONFIG['comment_needchinese'] == 1) checked="checked" @endif/>评论内容必须包含中文
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2 text-auto text-left-padding">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="comment_paging" id="comment_paging" @if($_SITECONFIG['comment_paging'] == 1) checked="checked" @endif/>评论分页，
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">每页显示</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                                <input maxlength="5" class="form-control" value="{{ $_SITECONFIG['comment_pnum'] }}" name="comment_pnum" placeholder="如：10"/>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">条评论，</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                                <select name="comment_order" class="form-control">
                                    <option value="1" @if($_SITECONFIG['comment_order'] == 1) selected="selected" @endif>较新的</option>
                                    <option value="0" @if($_SITECONFIG['comment_order'] == 0) selected="selected" @endif>较旧的</option>
                                </select>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">排在前面</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">上传设置</label>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-xs-2 text-auto text-left-padding">
                                <p class="form-control-static">附件上传最大限制</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                                <input maxlength="10" class="form-control" value="{{ $_SITECONFIG['att_maxsize'] }}" name="att_maxsize" placeholder="如：2048"/>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">KB。</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <input maxlength="200" class="form-control" value="{{ $_SITECONFIG['att_type'] }}" name="att_type" placeholder="rar,zip,gif,jpg,jpeg,png,txt,pdf,docx,doc,xls,xlsx" />
                                <span class="help-block">允许上传的附件类型（多个用半角逗号分隔）</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2 text-auto text-left-padding">
                                <p class="form-control-static">上传图片生成缩略图，最大尺寸：</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                                <input maxlength="5" class="form-control" value="{{ $_SITECONFIG['att_imgmaxw'] }}" name="att_imgmaxw" placeholder="如：420"/>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">x</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-3">
                               <input maxlength="5" class="form-control" value="{{ $_SITECONFIG['att_imgmaxh'] }}" name="att_imgmaxh" placeholder="如：460"/>
                            </div>
                            <div class="col-xs-2 text-auto text-padding">
                                <p class="form-control-static">（单位：像素）</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">备案号</label>
                    <div class="col-md-4">
                        <input maxlength="200" class="form-control" value="{{ $_SITECONFIG['icp'] }}" name="icp" placeholder="如：ICP123456789"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">底部信息</label>
                    <div class="col-md-4">
                        <textarea name="footer_info" cols="" rows="6" class="form-control" placeholder="如：hello world">{{ $_SITECONFIG['footer_info'] }}</textarea>
                        <span class="help-block">首页底部信息(支持html，可用于添加流量统计代码)</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-1 col-sm-10">
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