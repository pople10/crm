<?php

include_once 'beans/CommandeAchat.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class CommandeAchatService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO CommandeAchat (fournisseur,date,etat,devis) VALUES (?,?,?,NULL)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getEtat())) or die('Error');

        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'une nouvelle commande d'achat", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function getLastInserted() {
        $query = "select * from CommandeAchat where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($id) {

        $query = "DELETE FROM CommandeAchat WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'une commande d'achat", 'delete', null, $old, null));
    }

    public function findAll() {

        $query = "Select * from CommandeAchatView";

        $req = $this->connexion->getConnexion()->query($query);

        $familles = $req->fetchAll(PDO::FETCH_OBJ);

        return $familles;
    }

    public function findById($id) {

        $query = "SELECT * from CommandeAchat where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE CommandeAchat SET fournisseur=?,date=?,etat=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getEtat(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'une commande d'achat", 'update', null, $old, $new));
    }

    public function updateEtat($o) {

        $query = "UPDATE CommandeAchat SET etat=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getEtat(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'une commande d'achat", 'update', null, $old, $new));
    }

    public function getLastPrice($commande, $produit) {

        //$query = "SELECT bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from CommandeAchat b where b.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1";
        $query = "SELECT IF (EXISTS(SELECT @prix:=bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from CommandeAchat b where b.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1),@prix,(SELECT bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where p.reference = ? ORDER BY ba.date DESC LIMIT 1)) as prix";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($commande, $produit, $produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function CommandeToBon($commande) {
        try {
            $query = 'CALL CommandeToBon(:commande,:user,@result)';
            $req = $this->connexion->getConnexion()->prepare($query);
            $req->bindParam(':commande', $commande, PDO::PARAM_INT);
            $req->bindParam(':user', $_SESSION['user_id'], PDO::PARAM_INT);
            $req->execute();
            $req->closeCursor();
            $row = $this->connexion->getConnexion()->query("SELECT @result AS result")->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row !== false ? $row['result'] : null;
            }
        } catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }
        return null;
    }

    public function findEtatCommand() {
        $query = "SELECT c.etat as etat, count(*) as nbr
            from CommandeAchat c 
            group by c.etat";

        $req = $this->connexion->getConnexion()->query($query);

        $total = $req->fetchAll(PDO::FETCH_OBJ);

        return $total;
    }	
    /* Mohammed Amine added : */	
	public function LastID() {
        $query = "SELECT MAX(id) as Max FROM CommandeAchat WHERE 1";

        $req = $this->connexion->getConnexion()->query($query);

        $total = $req->fetchAll(PDO::FETCH_OBJ);

        return $total;
    }	
	/* End adding */

}
