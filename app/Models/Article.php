<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\User;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    protected $table = 'articles';

    // 应用标签
    use Taggable, SoftDeletes;

    // 关联评论一对多
    public function Comments()
    {
        return $this->hasMany(Comment::class, 'article_id', 'id');
    }
    // // 关联评论一对一
    // public function Comments()
    // {
    //     return $this->hasOne(Comment::class, 'article_id', 'id');
    // }
    // 关联用户一对一
    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
