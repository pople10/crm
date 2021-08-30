<?php

include_once 'beans/Marque.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
include_once 'service/HistoriqueActionService.php';

class MarqueService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {
        $query = "INSERT INTO Marque VALUES (NULL,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom())) or die('Error');
        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'une nouvelle marque", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function getLastInserted() {
        $query = "select * from Marque where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($o) {
        $query = "DELETE FROM Marque WHERE id = ?";
        $old = json_encode($this->findById($o));
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o)) or die("erreur delete");
        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'une marque", 'delete', null, $old, null));
    }

    public function findAll() {
        $query = "select * from Marque";
        $req = $this->connexion->getConnexion()->query($query);
        $marques = $req->fetchAll(PDO::FETCH_OBJ);
        return $marques;
    }

    public function findById($id) {
        $query = "select * from Marque where id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
        $query = "UPDATE Marque SET nom = ? where id = ?";
        $old = json_encode($this->findById($o->getId()));
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom(), $o->getId())) or die('Error');
        $new = json_encode($this->findById($o->getId()));
        $this->watch->create(new HistoriqueAction(null, null, "Modification d'une marque", 'update', null, $old, $new));
    }

}
