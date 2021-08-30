<?php
include_once 'beans/Role.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
class RoleService implements IDao {

    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $query = "INSERT INTO Role VALUES (NULL,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom())) or die('Error');
    }

    public function delete($o) {
        $query = "DELETE FROM Role WHERE id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o)) or die("erreur delete");
    }

    public function findAll() {
        $query = "select * from Role";
        $req = $this->connexion->getConnexion()->query($query);
        $roles = $req->fetchAll(PDO::FETCH_OBJ);
        return $roles;
    }

    public function findById($id) {
        $query = "select * from Role where id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function findByUserHavent($id) {
        $query = "select R.* from Role R where R.id not in (select UR.role from UserRole UR where UR.user = ? )";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
    public function findByUserHave($id) {
        $query = "select R.* from Role R where R.id in (select UR.role from UserRole UR where UR.user = ? )";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
        $query = "UPDATE Role SET nom = ? where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom(), $o->getId())) or die('Error');
    }

}
