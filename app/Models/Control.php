<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = 'controls';

    // Mass assignment pass field
    protected $fillable = ['option_name', 'option_value'];

    // 保存配置文件
    public function SaveConfig()
    {
        // 写入到配置文件 siteconfig.php
        return file_put_contents(config_path('siteconfig.php'), sprintf("<?php\n\n/**\n* 站点配置文件\n**/\n\nreturn %s;", var_export(self::MakeConfig($this->all()->toArray()), true)), LOCK_EX);
    }

    protected static function MakeConfig(array $array)
    {
        $arr = [];
        foreach ($array as $value) {
            $arr[$value['option_name']] = $value['option_value'] ?: '';
        }
        return $arr;
    }
}
