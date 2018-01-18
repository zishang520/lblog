<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Control;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class ControlController extends BaseController
{
    // 基本设置
    public function index()
    {
        $timezone = [
            'Etc/GMT' => '(UTC)协调世界时',
            'Africa/Casablanca' => '(UTC)卡萨布兰卡',
            'Atlantic/Reykjavik' => '(UTC)蒙罗维亚，雷克雅未克',
            'Europe/London' => '(UTC)都柏林，爱丁堡，里斯本，伦敦',
            'Africa/Lagos' => '(UTC+01:00)中非西部',
            'Europe/Paris' => '(UTC+01:00)布鲁塞尔，哥本哈根，马德里，巴黎',
            'Africa/Windhoek' => '(UTC+01:00)温得和克',
            'Europe/Warsaw' => '(UTC+01:00)萨拉热窝，斯科普里，华沙，萨格勒布',
            'Europe/Budapest' => '(UTC+01:00)贝尔格莱德，布拉迪斯拉发，布达佩斯，卢布尔雅那，布拉格',
            'Europe/Berlin' => '(UTC+01:00)阿姆斯特丹，柏林，伯尔尼，罗马，斯德哥尔摩，维也纳',
            'Europe/Istanbul' => '(UTC+02:00)伊斯坦布尔',
            'Europe/Kaliningrad' => '(UTC+02:00)加里宁格勒(RTZ 1)',
            'Africa/Johannesburg' => '(UTC+02:00)哈拉雷，比勒陀利亚',
            'Asia/Damascus' => '(UTC+02:00)大马士革',
            'Asia/Amman' => '(UTC+02:00)安曼',
            'Africa/Cairo' => '(UTC+02:00)开罗',
            'Africa/Tripoli' => '(UTC+02:00)的黎波里',
            'Asia/Jerusalem' => '(UTC+02:00)耶路撒冷',
            'Asia/Beirut' => '(UTC+02:00)贝鲁特',
            'Europe/Kiev' => '(UTC+02:00)赫尔辛基，基辅，里加，索非亚，塔林，维尔纽斯',
            'Europe/Bucharest' => '(UTC+02:00)雅典，布加勒斯特',
            'Africa/Nairobi' => '(UTC+03:00)内罗毕',
            'Asia/Baghdad' => '(UTC+03:00)巴格达',
            'Europe/Minsk' => '(UTC+03:00)明斯克',
            'Asia/Riyadh' => '(UTC+03:00)科威特，利雅得',
            'Europe/Moscow' => '(UTC+03:00)莫斯科，圣彼得堡，伏尔加格勒(RTZ 2)',
            'Asia/Tehran' => '(UTC+03:30)德黑兰',
            'Europe/Samara' => '(UTC+04:00)伊热夫斯克，萨马拉(RTZ 3)',
            'Asia/Yerevan' => '(UTC+04:00)埃里温',
            'Asia/Bak' => '(UTC+04:00)巴库',
            'Asia/Tbilisi' => '(UTC+04:00)第比利斯',
            'Indian/Mauritius' => '(UTC+04:00)路易港',
            'Asia/Dubai' => '(UTC+04:00)阿布扎比，马斯喀特',
            'Asia/Kabu' => '(UTC+04:30)喀布尔',
            'Asia/Karachi' => '(UTC+05:00)伊斯兰堡，卡拉奇',
            'Asia/Yekaterinburg' => '(UTC+05:00)叶卡捷琳堡(RTZ 4)',
            'Asia/Tashkent' => '(UTC+05:00)阿什哈巴德，塔什干',
            'Asia/Colombo' => '(UTC+05:30)斯里加亚渥登普拉',
            'Asia/Calcutta' => '(UTC+05:30)钦奈，加尔各答，孟买，新德里',
            'Asia/Katmandu' => '(UTC+05:45)加德满都',
            'Asia/Novosibirsk' => '(UTC+06:00)新西伯利亚(RTZ 5)',
            'Asia/Dhaka' => '(UTC+06:00)达卡',
            'Asia/Almaty' => '(UTC+06:00)阿斯塔纳',
            'Asia/Rangoon' => '(UTC+06:30)仰光',
            'Asia/Krasnoyarsk' => '(UTC+07:00)克拉斯诺亚尔斯克(RTZ 6)',
            'Asia/Bangkok' => '(UTC+07:00)曼谷，河内，雅加达',
            'Asia/Ulaanbaatar' => '(UTC+08:00)乌兰巴托',
            'Asia/Irkutsk' => '(UTC+08:00)伊尔库茨克(RTZ 7)',
            'Asia/Shanghai' => '(UTC+08:00)北京，重庆，香港特别行政区，乌鲁木齐',
            'Asia/Taipei' => '(UTC+08:00)台北',
            'Asia/Singapore' => '(UTC+08:00)吉隆坡，新加坡',
            'Australia/Perth' => '(UTC+08:00)珀斯',
            'Asia/Tokyo' => '(UTC+09:00)大阪，札幌，东京',
            'Asia/Yakutsk' => '(UTC+09:00)雅库茨克(RTZ 8)',
            'Asia/Seoul' => '(UTC+09:00)首尔',
            'Australia/Darwin' => '(UTC+09:30)达尔文',
            'Australia/Adelaide' => '(UTC+09:30)阿德莱德',
            'Pacific/Port_Moresby' => '(UTC+10:00)关岛，莫尔兹比港',
            'Australia/Sydney' => '(UTC+10:00)堪培拉，墨尔本，悉尼',
            'Australia/Brisbane' => '(UTC+10:00)布里斯班',
            'Asia/Vladivostok' => '(UTC+10:00)符拉迪沃斯托克，马加丹(RTZ 9)',
            'Australia/Hobart' => '(UTC+10:00)霍巴特',
            'Asia/Magadan' => '(UTC+10:00)马加丹',
            'Asia/Srednekolymsk' => '(UTC+11:00)乔库尔达赫(RTZ 10)',
            'Pacific/Guadalcanal' => '(UTC+11:00)所罗门群岛，新喀里多尼亚',
            'Etc/GMT-12' => '(UTC+12:00)协调世界时+12',
            'Pacific/Auckland' => '(UTC+12:00)奥克兰，惠灵顿',
            'Pacific/Fiji' => '(UTC+12:00)斐济',
            'Asia/Kamchatka' => '(UTC+12:00)阿纳德尔，彼得罗巴甫洛夫斯克-堪察加(RTZ 11)',
            'Pacific/Tongatapu' => '(UTC+13:00)努库阿洛法',
            'Pacific/Apia' => '(UTC+13:00)萨摩亚群岛',
            'Pacific/Kiritimati' => '(UTC+14:00)圣诞岛',
            'Atlantic/Azores' => '(UTC-01:00)亚速尔群岛',
            'Atlantic/Cape_Verde' => '(UTC-01:00)佛得角群岛',
            'Etc/GMT+2' => '(UTC-02:00)协调世界时-02',
            'America/Cayenne' => '(UTC-03:00)卡宴，福塔雷萨',
            'America/Sao_Paulo' => '(UTC-03:00)巴西利亚',
            'America/Buenos_Aires' => '(UTC-03:00)布宜诺斯艾利斯',
            'America/Godthab' => '(UTC-03:00)格陵兰',
            'America/Bahia' => '(UTC-03:00)萨尔瓦多',
            'America/Montevideo' => '(UTC-03:00)蒙得维的亚',
            'America/St_Johns' => '(UTC-03:30)纽芬兰',
            'America/La_Paz' => '(UTC-04:00)乔治敦，拉巴斯，马瑙斯，圣胡安',
            'America/Asuncion' => '(UTC-04:00)亚松森',
            'America/Halifax' => '(UTC-04:00)大西洋时间(加拿大)',
            'America/Cuiaba' => '(UTC-04:00)库亚巴',
            'America/Caracas' => '(UTC-04:30)加拉加斯',
            'America/New_York' => '(UTC-05:00)东部时间(美国和加拿大)',
            'America/Indianapolis' => '(UTC-05:00)印地安那州(东部)',
            'America/Bogota' => '(UTC-05:00)波哥大，利马，基多，里奥布朗库',
            'America/Guatemala' => '(UTC-06:00)中美洲',
            'America/Chicago' => '(UTC-06:00)中部时间(美国和加拿大)',
            'America/Mexico_City' => '(UTC-06:00)瓜达拉哈拉，墨西哥城，蒙特雷',
            'America/Regina' => '(UTC-06:00)萨斯喀彻温',
            'America/Phoenix' => '(UTC-07:00)亚利桑那',
            'America/Chihuahua' => '(UTC-07:00)奇瓦瓦，拉巴斯，马萨特兰',
            'America/Denver' => '(UTC-07:00)山地时间(美国和加拿大)',
            'America/Santa_Isabel' => '(UTC-08:00)下加利福尼亚州',
            'America/Los_Angeles' => '(UTC-08:00)太平洋时间(美国和加拿大)',
            'America/Anchorage' => '(UTC-09:00)阿拉斯加',
            'Pacific/Honolulu' => '(UTC-10:00)夏威夷',
            'Etc/GMT+11' => '(UTC-11:00)协调世界时-11',
            'Etc/GMT+12' => '(UTC-12:00)国际日期变更线西',
        ];
        return view('admin.control.index')->withTimezone($timezone);
    }

    // 基本设置更新
    public function indexput(Request $request)
    {
        // 数据验证
        $this->validate($request, [
            'blogurl' => 'bail|sometimes|nullable|url', // 选填url
            'login_type' => 'required|alpha|in:email,name', // 登陆类型
        ]);
        $config = [
            'blogname' => $request->get('blogname', ''), // 站点标题
            'bloginfo' => $request->get('bloginfo', ''), // 副标题
            'blogurl' => $request->get('blogurl', ''), // 站点地址
            'detect_url' => $request->get('detect_url', 0), // 是否开启自动识别url
            'index_lognum' => $request->get('index_lognum', 0), // 分页设置
            'timezone' => $request->get('timezone', 'Asia/ShangHai'), // 时区设置
            'login_code' => $request->get('login_code', 0), // 是否开启登陆验证码0关闭
            'login_type' => $request->get('login_type', 'email'), // 登陆方式
            'isexcerpt' => $request->get('isexcerpt', 0), // 是否开启自动摘要0关闭
            'excerpt_subnum' => $request->get('excerpt_subnum', 0), // 摘要显示长度
            'rss_output_num' => $request->get('rss_output_num', 0), // RSS输出数量
            'rss_output_fulltext' => $request->get('rss_output_fulltext', 1), // RSS输出方式
            'iscomment' => $request->get('iscomment', 0), // 是否开启评论
            'comment_interval' => $request->get('comment_interval', 0), // 评论时间间隔
            'ischkcomment' => $request->get('ischkcomment', 0), // 是否开启评论审核
            'comment_code' => $request->get('comment_code', 0), // 是否开启评论验证码
            'isgravatar' => $request->get('isgravatar', 0), // 是否开启评论人头像
            'comment_needchinese' => $request->get('comment_needchinese', 0), // 是否开启评论内容必须包含中文
            'comment_paging' => $request->get('comment_paging', 0), // 是否开启评论分页
            'comment_pnum' => $request->get('comment_pnum', 0), // 每页显示评论数量
            'comment_order' => $request->get('comment_order', 0), // 评论显示排序
            'att_maxsize' => $request->get('att_maxsize', 1024), // 附件最大上传显示
            'att_type' => $request->get('att_type', ''), // 允许上传的文件后最
            'att_imgmaxw' => $request->get('att_imgmaxw', 0), // 上传图片生成缩略图宽
            'att_imgmaxh' => $request->get('att_imgmaxh', 0), // 上传图片生成缩略图高
            'icp' => $request->get('icp', ''), // 备案号
            'footer_info' => $request->get('footer_info', ''), // 底部信息
        ];
        $Control = new Control;
        foreach ($config as $key => $value) {
            $Control->updateOrCreate(['option_name' => $key], ['option_value' => $value]);
        }
        if ($Control->SaveConfig()) {
            return redirect('admin/control');
        } else {
            return redirect()->back()->withErrors('保存失败！');
        }
    }

    // seo优化
    public function seo()
    {
        return view('admin.control.seo');
    }

    // seo优化更新
    public function seoput(Request $request)
    {
        $config = [
            'permalink' => $request->get('permalink', 0), // 链接形式
            'isalias' => $request->get('isalias', 0), // 启用文章链接别名
            'isalias_html' => $request->get('isalias_html', 0), // 启用文章链接别名html后缀
            'site_title' => $request->get('site_title', ''), // 站点浏览器标题(title)
            'site_key' => $request->get('site_key', ''), // 站点关键字(keywords)
            'site_description' => $request->get('site_description', ''), // 站点浏览器描述(description)
            'log_title_style' => $request->get('log_title_style', 0), // 文章浏览器标题方案
        ];
        $Control = new Control;
        foreach ($config as $key => $value) {
            $Control->updateOrCreate(['option_name' => $key], ['option_value' => $value]);
        }
        if ($Control->SaveConfig()) {
            return redirect('admin/control/seo');
        } else {
            return redirect()->back()->withErrors('保存失败！');
        }
    }

    // 个人设置
    public function personal()
    {
        return view('admin.control.personal')->withUser(auth()->user());
    }

    // 个人设置更新
    public function personalput(Request $request)
    {
        // 数据验证
        $this->validate($request, [
            'nickname' => 'bail|sometimes|nullable|max:255',
            // 'description' => 'sometimes|nullable',
            'email' => 'bail|required|email',
            'name' => 'bail|required|alpha_dash|max:26',
            'oldpass' => 'bail|sometimes|nullable|min:6|max:18',
            'newpass' => 'bail|sometimes|nullable|min:6|max:18',
            'repeatpass' => 'sometimes|nullable|confirmed:newpass|min:6|max:18',
        ]);

        $id = $request->user()->id;
        $newpassword = trim($request->get('newpass', ''));
        $repeatpass = trim($request->get('repeatpass', ''));
        $oldpass = trim($request->get('oldpass', ''));

        // 获取用户信息
        $User = User::find($id);

        $updatedata = [
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'nickname' => trim($request->get('nickname', '')),
            'description' => trim($request->get('description', '')),
        ];

        $is_changepass = false;
        // 判断是否需要更改密码
        if (!empty($repeatpass) && !empty($newpassword) && !empty($oldpass)) {
            if (!Hash::check($oldpass, $User->password)) {
                return redirect()->back()->withErrors('旧密码错误！');
            }
            $updatedata['password'] = bcrypt($newpassword);
            $is_changepass = true;
        }

        if ($User->update($updatedata)) {
            // 判断是否需要退出登陆
            if ($is_changepass) {
                auth()->logout();
                return redirect('login');
            }
            return redirect('admin/control/personal');
        } else {
            return redirect()->back()->withErrors('保存失败！');
        }
    }

    // 上传图片并剪切
    public function upphoto(Request $request)
    {
        $this->validate($request, [
            'picture' => 'mimes:jpeg,bmp,png,jpg,gif',
        ]);

        if (!$request->hasFile('picture')) {
            return response()->json([
                'status' => false,
                'message' => 'The upload file does not exist',
            ], 200);
        }

        $file = $request->file('picture');

        if (!$file->isValid()) {
            return response()->json([
                'status' => false,
                'message' => 'The uploaded file is invalid',
            ], 200);
        }

        if (!($image_info = getimagesize($file->path()))) {
            return response()->json([
                'status' => false,
                'message' => 'The file is not a picture',
            ], 200);
        }

        $args = json_decode($request->get('avatar_data', '{}'), true);
        // //防止伪造
        $obj = array(
            'width' => isset($args['width']) && is_numeric($args['width']) && $args['width'] > 0 ? intval($args['width']) : $image_info[0],
            'height' => isset($args['height']) && is_numeric($args['height']) && $args['height'] > 0 ? intval($args['height']) : $image_info[1],
            'x' => isset($args['x']) && is_numeric($args['x']) && $args['x'] > 0 ? intval($args['x']) : 0,
            'y' => isset($args['y']) && is_numeric($args['y']) && $args['y'] > 0 ? intval($args['y']) : 0,
            'rotate' => isset($args['rotate']) && is_numeric($args['rotate']) ? intval($args['rotate']) : 0,
        );
        $image = new ImageManager;
        $new_file_name = $request->user()->id . 'photo.' . $file->extension();
        $image->make($file->path())->encode($file->extension())->rotate(-$obj['rotate'])->crop($obj['width'], $obj['height'], $obj['x'], $obj['y'])->resize(80, 80)->save(public_path('uploads/User/' . $new_file_name));
        if (!$image) {
            return response()->json([
                'status' => false,
                'message' => 'Server error while uploading',
            ], 200);
        }
        // 获取用户信息
        if (User::find($request->user()->id)->update(['photo' => '/uploads/User/' . $new_file_name])) {
            return response()->json([
                'status' => true,
                'url' => '/uploads/User/' . $new_file_name,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Image failed to save database',
            ], 200);
        }
    }
}
