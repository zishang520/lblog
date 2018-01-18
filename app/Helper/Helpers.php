<?php

/**
 * 公共函数库
 *  "autoload": {
 *       "files": [
 *           "app/Function/Function.php"
 *        ]
 *   }
 */

/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings, $start, $length)
{
    if (function_exists('mb_substr') && function_exists('mb_strlen')) {
        $sub_str = mb_substr($strings, $start, $length, 'utf8');
        return mb_strlen($sub_str, 'utf8') < mb_strlen($strings, 'utf8') ? $sub_str . '...' : $sub_str;
    }
    $str = substr($strings, $start, $length);
    $char = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        if (ord($str[$i]) >= 128) {
            $char++;
        }

    }
    $str2 = substr($strings, $start, $length + 1);
    $str3 = substr($strings, $start, $length + 2);
    if ($char % 3 == 1) {
        if ($length <= strlen($strings)) {
            $str3 = $str3 .= '...';
        }
        return $str3;
    }
    if ($char % 3 == 2) {
        if ($length <= strlen($strings)) {
            $str2 = $str2 .= '...';
        }
        return $str2;
    }
    if ($char % 3 == 0) {
        if ($length <= strlen($strings)) {
            $str = $str .= '...';
        }
        return $str;
    }
}

/**
 * 从可能包含html标记的内容中萃取纯文本摘要
 *
 * @param string $data
 * @param int $len
 */
function extractHtmlData($data, $len)
{
    $data = subString(strip_tags($data), 0, $len + 30);
    $search = array("/([\r\n])[\s]+/", // 去掉空白字符
        "/&(quot|#34);/i", // 替换 HTML 实体
        "/&(amp|#38);/i",
        "/&(lt|#60);/i",
        "/&(gt|#62);/i",
        "/&(nbsp|#160);/i",
        "/&(iexcl|#161);/i",
        "/&(cent|#162);/i",
        "/&(pound|#163);/i",
        "/&(copy|#169);/i",
        "/\"/i",
    );
    $replace = array(" ", "\"", "&", " ", " ", "", chr(161), chr(162), chr(163), chr(169), "");
    $data = trim(subString(preg_replace($search, $replace, $data), 0, $len));
    return $data;
}

/**
 * [MakeLoginType 获取登陆type]
 * @Author    ZiShang520@gmail.com
 * @DateTime  2016-12-02T12:59:07+0800
 * @copyright (c)                      ZiShang520 All           Rights Reserved
 * @param     [type]                   $str       [description]
 */
function MakeLoginType($str)
{
    switch ($str) {
        case 'name':return 'text';
        default:return 'email';
    }
}

/**
 * [NavbarType 获取类型]
 * @Author    ZiShang520@gmail.com
 * @DateTime  2016-12-24T16:25:02+0800
 * @copyright (c)                      ZiShang520 All           Rights Reserved
 * @param     string                   $value     [htmlcode]
 */
function NavbarType($value = '')
{
    switch ($value) {
        case 0:return '<span class="text-warning">自定</span>';
        case 1:
        case 2:return '<span class="text-muted">系统</span>';
        case 3:return '<span class="text-primary">分类</span>';
        case 4:return '<span class="text-success">页面</span>';
    }
}

/**
 * [NavbarUrl 获取导航地址]
 * @Author    ZiShang520@gmail.com
 * @DateTime  2016-12-24T16:28:59+0800
 * @copyright (c)                      ZiShang520 All           Rights Reserved
 * @param     integer                  $type     [导航类型id]
 * @param     integer                  $type_id   [导航id]
 * @param     string                   $url       [自定义导航地址]
 */
function NavbarUrl($type = -1, $type_id = 0, $url = '')
{
    switch ($type) {
        case 0:
            return $url;
        case 1:
            return url('/');
        case 2:
            return url('/admin');
        case 3:
            return url('/sort/' . $type_id);
        case 4:
            return url('/page/' . $type_id);
    }
}
