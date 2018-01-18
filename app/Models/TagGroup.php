<?php

namespace App\Models;

use Conner\Tagging\Model\TagGroup as TaggableTagGroup;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * TagGroup 继承 TaggableTagGroup 模型
 */
class TagGroup extends TaggableTagGroup
{
    use SoftDeletes;
    protected $table = 'tagging_tag_groups';
}