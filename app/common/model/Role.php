<?php

namespace app\common\model;

class Role extends BaseModel
{
    // 关联节点
    public function nodes()
    {
        return $this->belongsToMany(Node::class);
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class, AdminRole::class);
    }
}
