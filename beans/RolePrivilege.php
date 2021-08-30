<?php


class RolePrivilege
{
    private $role;
    private $privilege;

    /**
     * RolePrivilege constructor.
     * @param $role
     * @param $privilege
     */
    public function __construct($role, $privilege)
    {
        $this->role = $role;
        $this->privilege = $privilege;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param mixed $privilege
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
    }

}