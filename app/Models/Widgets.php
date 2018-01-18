<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    protected $table = 'widgets';

    // 保存配置文件
    public function SaveConfig()
    {
        // 写入到配置文件 widgets.php
        return file_put_contents(config_path('widgets.php'), sprintf("<?php\n\n/**\n* 组件缓存文件\n**/\n\nreturn %s;", var_export(self::MakeConfig($this->all()->toArray()), true)), LOCK_EX);
    }

    protected static function MakeConfig(array $array)
    {
        $arr = [];
        foreach ($array as $value) {
            $arr[$value['name']] = json_decode($value['value'], true);
            $arr[$value['name']]['isdefault'] = boolval($value['isdefault']);
        }
        return $arr;
    }
}
