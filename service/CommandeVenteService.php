<?php

include_once 'beans/CommandeVente.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class CommandeVenteService implements IDao
{

    private $connexion;
    private $watch;



    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();

    }



    public function create($o) {

        $query = "INSERT INTO CommandeVente (client,date,etat,devis) VALUES (?, ?,?,NULL)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getClient(),$o->getDate(),$o->getEtat())) or die('Error');
        
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'une nouvelle commande de vente",'add',null,null,json_encode($this->getLastInserted())));

    }



    public function delete($id) {

        $query = "DELETE FROM CommandeVente WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));
        $req->execute(array($id)) or die("erreur delete");
        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'une commande de vente", 'delete', null, $old, null));

    }

    public function getLastInserted()
    {
        $query = "select * from CommandeVente where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }


    public function findAll() {

        $query = "Select * from CommandeVenteView";

        $req = $this->connexion->getConnexion()->query($query);

        $familles = $req->fetchAll(PDO::FETCH_OBJ);

        return $familles;

    }



    public function findById($id) {

        $query = "SELECT * from CommandeVente where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE CommandeVente SET client=?,date=?,etat=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));
        $req->execute(array($o->getClient(),$o->getDate(),$o->getEtat(), $o->getId())) or die('Error');
        $new = json_encode($this->findById($o->getId()));
        $this->watch->create(new HistoriqueAction(null,null,"Modification d'une commande de vente",'update',null,$old,$new));

    }

    public function updateEtat($o) {

        $query = "UPDATE CommandeVente SET etat=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getEtat(), $o->getId())) or die('Error');

    }

    public function getLastPrice($produit) {

//        $query = "SELECT bap.prix FROM BonVenteProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonVente ba on ba.id = bap.bon where ba.client in (select b.Client from CommandeVente b where b.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1";
        $query = "select MAX(bap.prix)*2 as prix from BonAchatProduit bap where bap.produit = ?";
        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function CommandeToBon($commande) {
        try {
            $query = 'CALL CommandeToBonVente(:commande,:user,@result)';
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
            from CommandeVente c 
            group by c.etat";

        $req = $this->connexion->getConnexion()->query($query);

        $total = $req->fetchAll(PDO::FETCH_OBJ);

        return $total;
    }
    
    /* Mohammed Added : */
    public function LastID() {
        $query = "SELECT MAX(id) as Max FROM CommandeVente WHERE 1";

        $req = $this->connexion->getConnexion()->query($query);

        $total = $req->fetchAll(PDO::FETCH_OBJ);

        return $total;
    }
    /* End Adding */
	
}