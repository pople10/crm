<?php

include_once 'beans/FactureAchat.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class FactureAchatService Implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO FactureAchat (fournisseur,date,type,bon) VALUES (?,?,?,NULL)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getType())) or die('Error');

        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'une nouvelle facture d'achat", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function getLastInserted() {
        $query = "select * from FactureAchat where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($id) {

        $query = "DELETE FROM FactureAchat WHERE id = ?";

        $old = json_encode($this->findById($id));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'une facture d'achat", 'delete', null, $old, null));
    }

    public function findAll() {

        $query = "Select * from FactureAchatView";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }

    public function findById($id) {

        $query = "SELECT * from FactureAchat where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function getLastPrice($facture, $produit) {

        //$query = "SELECT * FROM BonAchatProduit bap inner join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from FactureAchat b where b.id = ?) and bap.produit = ? order by ba.id desc LIMIT 1";
        $query = "SELECT IF (EXISTS(SELECT @prix:=bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from FactureAchat b where b.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1),@prix,(SELECT bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where p.reference = ? ORDER BY ba.date DESC LIMIT 1)) as prix";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($facture, $produit, $produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE FactureAchat SET fournisseur=?,date=?,type=? where id = ?";

        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getType(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));
        $this->watch->create(new HistoriqueAction(null, null, "Modification d'une facture d'achat", 'update', null, $old, $new));
    }

    public function updateType($o) {

        $query = "UPDATE FactureAchat SET type=? where id = ?";

        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getType(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'une facture d'achat", 'update', null, $old, $new));
    }
    public function LastID() {

        $query = "SELECT MAX(id) as Max from FactureAchat";

        $req = $this->connexion->getConnexion()->query($query);

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

}
