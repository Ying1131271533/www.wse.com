<?php

namespace app\common\model;

class Node extends BaseModel
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, RoleNode::class);
    }
    
}
