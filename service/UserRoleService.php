<?php
include_once 'beans/UserRole.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
class UserRoleService implements IDao {

    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $query = "INSERT INTO UserRole VALUES (?,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getUser(),$o->getRole())) or die('Error');
    }

    public function delete($o) {
        $query = "DELETE FROM UserRole WHERE user = ? and role = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getUser(),$o->getRole())) or die("erreur delete");
    }

    public function findAll() {
        $query = "select * from UserRole";
        $req = $this->connexion->getConnexion()->query($query);
        $roles = $req->fetchAll(PDO::FETCH_OBJ);
        return $roles;
    }

    public function findById($o) {
        $query = "select * from UserRole where user =? and role = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getUser(),$o->getRole()));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
        $query = "";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o)) or die('Error');
    }

}
