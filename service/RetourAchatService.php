<?php

include_once 'beans/RetourAchat.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class RetourAchatService Implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {
        $query = "INSERT INTO RetourAchat (fournisseur,date_creation,date_envoi,etat) VALUES (?,?,?,?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDateCreation(), $o->getDateEnvoi(), $o->getEtat())) or die('Error');

        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'un nouveau retour d'achat", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function getLastInserted() {
        $query = "select * from RetourAchat where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($id) {
        $r = true;
        $query = "DELETE FROM RetourAchat WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or $r = false;

        if ($r)
            $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un retour d'achat", 'delete', null, $old, null));

        return $r;
    }

    public function findAll() {

        $query = "Select * from RetourAchatView";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }

    public function findById($id) {

        $query = "SELECT * from RetourAchat where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function getLastPrice($retour, $produit) {

        //$query = "SELECT * FROM BonAchatProduit bap inner join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from RetourAchat b where b.id = ?) and bap.produit = ? order by ba.id desc LIMIT 1";
        $query = "SELECT IF (EXISTS(SELECT @prix:=bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from RetourAchat b where b.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1),@prix,(SELECT bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where p.reference = ? ORDER BY ba.date DESC LIMIT 1)) as prix";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($retour, $produit, $produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function findTotalByMonth() {

        $query = "SELECT month(date_creation) as mois, SUM(bap.prix * bap.quantite) as total FROM RetourAchat ab inner join RetourAchatProduit bap on ab.id = bap.retour where year(date_creation) = year(NOW()) GROUP by month(date_creation)";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }

    public function update($o) {

        $query = "UPDATE RetourAchat SET fournisseur=?,date_creation=?,date_envoi=?,etat=? where id = ?";

        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDateCreation(), $o->getDateEnvoi(), $o->getEtat(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un retour d'achat", 'update', null, $old, $new));
    }

    public function updateEtat($o) {

        $query = "UPDATE RetourAchat SET etat=?,date_envoi=? where id = ?";

        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getEtat(), $o->getDateEnvoi(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un retour d'achat", 'update', null, $old, $new));
    }
    
    /* Mohammed Amine Added : */
    public function LastID() {

        $query = "SELECT MAX(id) as Max from RetourAchat";

        $req = $this->connexion->getConnexion()->query($query);

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }
    /* End Adding */

}
