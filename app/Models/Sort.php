<?php

namespace App\Models;

use App\Models\Article;
use Baum\Node as SortNode;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sort extends SortNode
{
    use SoftDeletes;
    protected $table = 'sorts';

    // 默认不是root节点
    protected $SortIsRoot = false;

    // 一对多关联文章
    public function hasManyArticles()
    {
        return $this->hasMany(Article::class, 'sort_id', 'id');
    }

    // 设置为root节点
    public function SortIsRoot()
    {
        $this->SortIsRoot = true;
        return $this;
    }

    /**
     * Move to the new parent if appropiate.
     *
     * @return void
     */
    public function moveToNewParent()
    {
        $pid = static::$moveToNewParentId;
        if (is_null($pid) || $this->SortIsRoot) {
            $this->makeRoot();
        } else if ($pid !== false) {
            $this->makeChildOf($pid);
        }
        return $this;
    }

    // 获取非自己的所有节点
    public function NotSelfAndChilds()
    {
        return $this->newNestedSetQuery()
            ->where($this->getLeftColumnName(), '<', $this->getLeft())
            ->orWhere($this->getRightColumnName(), '>', $this->getRight());
    }

    /**
     * 获取非自己的所有节点
     *
     * @param  array  $columns
     */
    public function getNotSelfAndChilds($columns = array('*'))
    {
        return $this->NotSelfAndChilds()->get($columns);
    }

}
