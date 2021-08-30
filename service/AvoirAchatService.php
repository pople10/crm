<?php

include_once 'beans/AvoirAchat.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class AvoirAchatService Implements IDao {

    private $connexion;
    private $watch;

    function __construct() {
        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO AvoirAchat (fournisseur,date,type,bon) VALUES (?, ?,?,NULL)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getType())) or die('Error');

        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'un nouveau avoir d'achat", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function getLastInserted() {
        $query = "select * from AvoirAchat where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($id) {

        $query = "DELETE FROM AvoirAchat WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un avoir d'achat", 'delete', null, $old, null));
    }

    public function findAll() {

        $query = "select * from AvoirAchatView";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }

    public function findById($id) {

        $query = "SELECT * from AvoirAchat where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function getLastPrice($avoir, $produit) {

        //$query = "SELECT * FROM BonAchatProduit bap inner join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from AvoirAchat b where b.id = ?) and bap.produit = ? order by ba.id desc LIMIT 1";
        $query = "SELECT IF (EXISTS(SELECT @prix:=bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from AvoirAchat b where b.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1),@prix,(SELECT bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where p.reference = ? ORDER BY ba.date DESC LIMIT 1)) as prix";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($avoir, $produit, $produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE AvoirAchat SET fournisseur=?,date=?,type=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getType(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un avoir d'achat", 'update', null, $old, $new));
    }

    public function updateType($o) {

        $query = "UPDATE AvoirAchat SET type=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getType(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un avoir d'achat", 'update', null, $old, $new));
    }
    /* Mohammed Amine AYACHE added : */
    public function LastID() {

        $query = "SELECT MAX(id) as Max from AvoirAchat";

        $req = $this->connexion->getConnexion()->query($query);

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }
    /* End Adding */

}
