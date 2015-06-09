<?php

namespace Illuminate3\User;

class PermissionRepository
{
    /**
     *
     * @var array
     */
    protected $permissions = array();
    
    /**
     * 
     * @param string $category
     * @param array $permissions
     */
    public function setPermissions($category, Array $permissions)
    {
        $this->permissions = array_merge($this->permissions, array($category => $permissions));
    }

    /**
     * 
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

}