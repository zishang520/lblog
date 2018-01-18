<?php

namespace App\Models;

use Conner\Tagging\Model\Tagged as TaggableTagged;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Tagged 继承 TaggableTagged 模型
 */
class Tagged extends TaggableTagged
{
    use SoftDeletes;
    protected $table = 'tagging_tagged';
}