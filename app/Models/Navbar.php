<?php

namespace App\Models;

use Baum\Node as NavbarNode;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navbar extends NavbarNode
{
    use SoftDeletes;
    protected $table = 'navbars';

    // 默认不是root节点
    protected $NavbarIsRoot = false;

    // 设置为root节点
    public function NavbarIsRoot()
    {
        $this->NavbarIsRoot = true;
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
        if (is_null($pid) || $this->NavbarIsRoot) {
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

    // 添加
    public static function addNavbar($data = [], $type = 0)
    {
        if (empty($data) || empty($type)) {
            return false;
        }
        $navbar = new static;
        $time = date('Y-m-d H:i:s');
        $_data = [];
        foreach ($data as $key => $value) {
            array_push($_data, [
                'taxis' => 0,
                'type_id' => $key,
                'navname' => $value,
                'type' => $type,
                'created_at' => $time,
                'updated_at' => $time,
            ]);
        }
        return $navbar->insert($_data);
    }
}
