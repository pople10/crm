<?php
include_once 'beans/RolePrivilege.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';


class RolePrivilegeService implements IDao
{
    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $r = true;
        $query = "INSERT INTO RolePrivilege VALUES (?,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getRole(),$o->getPrivilege())) or $r=false;
        return $r;
    }

    public function delete($o) {
        $r = true;
        $query = "DELETE FROM RolePrivilege WHERE role = ? and privilege = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getRole(),$o->getPrivilege())) or $r=false;
        return $r;
    }

    public function findAll() {
        $query = "select * from RolePrivilege";
        $req = $this->connexion->getConnexion()->query($query);
        $roles = $req->fetchAll(PDO::FETCH_OBJ);
        return $roles;
    }

    public function findAllRolePrivilege() {
        $query = "select R.id as role,R.nom,P.id as privilege,P.module from Privilege P inner JOIN Role R where P.id in (select RP.privilege from RolePrivilege RP where RP.role =R.id )";
        $req = $this->connexion->getConnexion()->query($query);
        $roles = $req->fetchAll(PDO::FETCH_OBJ);
        return $roles;
    }


    public function findById($o) {
        $query = "select * from RolePrivilege where role = ? and privilege = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getRole(),$o->getPrivilege()));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
        $query = "";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o)) or die('Error');
    }
}