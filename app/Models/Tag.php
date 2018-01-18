<?php

namespace App\Models;

use App\Models\Tagged;
use Conner\Tagging\Model\Tag as TaggableTag;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Tag 继承 TaggableTag 模型
 */
class Tag extends TaggableTag
{
    use SoftDeletes;

    protected $table = 'tagging_tags';

    public function tagged()
    {
        return $this->hasMany(Tagged::class, 'tag_slug', 'slug');
    }

    public function taggedhasOne()
    {
        return $this->hasOne(Tagged::class, 'tag_slug', 'slug');
    }
}
