<?php

include_once 'beans/Emplacement.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
include_once 'service/HistoriqueActionService.php';

class EmplacementService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {
        $query = "INSERT INTO Emplacement VALUES (NULL,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom())) or die('Error');
        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'un nouveau emplacement", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function getLastInserted() {
        $query = "select * from Emplacement where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($o) {
        $query = "DELETE FROM Emplacement WHERE id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($o));
        $req->execute(array($o)) or die("erreur delete");
        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un emplacement", 'delete', null, $old, null));
    }

    public function findAll() {
        $query = "select * from Emplacement";
        $req = $this->connexion->getConnexion()->query($query);
        $emplacements = $req->fetchAll(PDO::FETCH_OBJ);
        return $emplacements;
    }

    public function findById($id) {
        $query = "select * from Emplacement where id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
        $query = "UPDATE Emplacement SET nom = ? where id = ?";
        $old = json_encode($this->findById($o->getId()));
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom(), $o->getId())) or die('Error');
        $new = json_encode($this->findById($o->getId()));
        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un emplacement", 'update', null, $old, $new));
    }

}
