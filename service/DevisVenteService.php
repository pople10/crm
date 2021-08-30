<?php

include_once 'beans/DevisVente.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class DevisVenteService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO DevisVente (client,date,type) VALUES (?,?,?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getClient(), $o->getDate(), $o->getType())) or die('Error');

        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'un nouveau devis de vente", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function delete($id) {

        $query = "DELETE FROM DevisVente WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un devis de vente", 'delete', null, $old, null));
    }

    public function getLastInserted() {
        $query = "select * from DevisVente where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function findAll() {

        $query = "Select * from DevisVenteView";

        $req = $this->connexion->getConnexion()->query($query);

        $dv = $req->fetchAll(PDO::FETCH_OBJ);

        return $dv;
    }

    public function findById($id) {

        $query = "SELECT * from DevisVente where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE DevisVente SET client=?,date=?,type=? where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($o->getId()));
        $req->execute(array($o->getClient(), $o->getDate(), $o->getType(), $o->getId())) or die('Error');
        $new = json_encode($this->findById($o->getId()));
        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un devis de vente", 'update', null, $old, $new));
    }

    public function updateType($o) {

        $query = "UPDATE DevisVente SET type=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getType(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un devis de vente", 'update', null, $old, $new));
    }

    public function getLastPrice($produit) {

        //$query = "SELECT  bap.prix - bap.prix * (select web/100 from Client WHERE id = ? ) as prix
//        $query = "SELECT  bap.prix as prix
//                FROM BonVenteProduit bap
//                inner JOIN Produit p
//                on bap.produit = p.reference
//                inner Join BonVente ba
//                on ba.id = bap.bon
//                where p.reference = ?
//                ORDER BY ba.date DESC
//                LIMIT 1;";

        $query = "select MAX(bap.prix)*2 as prix from BonAchatProduit bap where bap.produit = ?";
        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function DevisToCommande($devis) {
        try {

            $query = 'CALL DevisToCommandeVente(:devis,:user,@result)';
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
    /* Mohammed Amine AYACHE Added : */
    public function LastID()
    {
        $query="SELECT MAX(id) as Max FROM DevisVente WHERE 1";
        $req = $this->connexion->getConnexion()->query($query);

        $dv = $req->fetchAll(PDO::FETCH_OBJ);

        return $dv;
    }
    /* End Adding */

}
