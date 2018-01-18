<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    // 批量赋值 避免出现token
    protected $fillable = ['nickname', 'email', 'website', 'content', 'article_id', 'ip'];

    // 关联文章一对一
    public function Article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }
}
