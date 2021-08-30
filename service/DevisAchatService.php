<?php

include_once 'beans/DevisAchat.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class DevisAchatService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO DevisAchat (fournisseur,date,type) VALUES (?, ?,?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getType())) or die('Error');

        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'un nouveau devis d'achat", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function delete($id) {

        $query = "DELETE FROM DevisAchat WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un devis d'achat", 'delete', null, $old, null));
    }

    public function getLastInserted() {
        $query = "select * from DevisAchat where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function findAll() {

        $query = "SELECT * from DevisAchatView";

        $req = $this->connexion->getConnexion()->query($query);

        $familles = $req->fetchAll(PDO::FETCH_OBJ);

        return $familles;
    }

    public function findById($id) {

        $query = "SELECT * from DevisAchat where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE DevisAchat SET fournisseur=?,date=?,type=? where id = ?";

        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getType(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un devis d'achat", 'update', null, $old, $new));
    }

    public function updateType($o) {

        $query = "UPDATE DevisAchat SET type=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getType(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un devis d'achat", 'update', null, $old, $new));
    }

    public function getLastPrice($devis, $produit) {

        //$query = "SELECT bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select d.Fournisseur from DevisAchat d where d.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1";
        $query = "SELECT IF (EXISTS(SELECT @prix:=bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select d.Fournisseur from DevisAchat d where d.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1),@prix,(SELECT bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where p.reference = ? ORDER BY ba.date DESC LIMIT 1)) as prix";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($devis, $produit, $produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function DevisToCommande($devis) {
        try {

            $query = 'CALL DevisToCommande(:devis,:user,@result)';
            $req = $this->connexion->getConnexion()->prepare($query);
            $req->bindParam(':devis', $devis, PDO::PARAM_INT);
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
    /* Mohammed Amine AYACHE : */
    public function LastID() {

        $query="SELECT MAX(id) as Max FROM DevisAchat WHERE 1";
        
        $req = $this->connexion->getConnexion()->query($query);

        $dv = $req->fetch(PDO::FETCH_OBJ);

        return $dv;
    }
    /* End Adding */

}
