<?php

include_once 'beans/Categorie.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
include_once 'service/HistoriqueActionService.php';

class CategorieService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {
        $query = "INSERT INTO Categorie VALUES (NULL,?, ?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getCode(), $o->getLibelle())) or die('Error');
        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'une nouvelle catégorie", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function getLastInserted() {
        $query = "select * from Categorie where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($o) {
        $query = "DELETE FROM Categorie WHERE id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($o));
        $req->execute(array($o)) or die("erreur delete");
        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'une catégorie", 'delete', null, $old, null));
    }

    public function findAll() {
        $query = "select * from Categorie";
        $req = $this->connexion->getConnexion()->query($query);
        $categories = $req->fetchAll(PDO::FETCH_OBJ);
        return $categories;
    }

    public function findCountProductByCategory() {
        $query = "select c.libelle as 'categorie', count(*) as 'nbr'
            from Categorie c 
            INNER JOIN Produit p
            on c.id = p.categorie
            group by c.libelle";
        $req = $this->connexion->getConnexion()->query($query);
        $categories = $req->fetchAll(PDO::FETCH_OBJ);
        return $categories;
    }

    public function findById($id) {
        $query = "select * from Categorie where id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
        $query = "UPDATE Categorie SET code = ?, libelle = ? where id = ?";
        $old = json_encode($this->findById($o->getId()));
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getCode(), $o->getLibelle(), $o->getId())) or die('Error');
        $new = json_encode($this->findById($o->getId()));
        $this->watch->create(new HistoriqueAction(null, null, "Modification d'une catégorie", 'update', null, $old, $new));
    }

}
