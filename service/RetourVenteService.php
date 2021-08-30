<?php

include_once 'beans/RetourVente.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class RetourVenteService Implements IDao {

    private $connexion;
    private $watch;



    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();

    }

    public function create($o) {
        $query = "INSERT INTO RetourVente (client,date_creation,date_envoi,etat) VALUES (?,?,?,?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getClient(), $o->getDateCreation(),$o->getDateEnvoi(), $o->getEtat())) or die('Error');
        
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau retour de vente",'add',null,null,json_encode($this->getLastInserted())));

    }
    
    public function getLastInserted(){
        $query = "select * from RetourVente where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }


    public function delete($id) {
        $r = true;
        $query = "DELETE FROM RetourVente WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or $r = false;

        if($r)
            $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un retour de vente", 'delete', null, $old, null));

        return $r;
    }



    public function findAll() {

        $query = "Select * from RetourVenteView";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;

    }



    public function findById($id) {

        $query = "SELECT * from RetourVente where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function getLastPrice($produit) {

//        $query = "SELECT * FROM BonVenteProduit bap inner join BonVente ba on ba.id = bap.bon where ba.client in (select b.Client from RetourVente b where b.id = ?) and bap.produit = ? order by ba.id desc LIMIT 1";

        $query = "select MAX(bap.prix)*2 as prix from BonAchatProduit bap where bap.produit = ?";
        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function findTotalByMonth() {

        $query = "SELECT month(date_creation) as mois, SUM(bap.prix * bap.quantite) as total FROM RetourVente ab inner join RetourVenteProduit bap on ab.id = bap.retour where year(date_creation) = year(NOW()) GROUP by month(date_creation)";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }

    public function update($o) {

        $query = "UPDATE RetourVente SET client=?,date_creation=?,date_envoi=?,etat=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));
        
        $req->execute(array($o->getClient(), $o->getDateCreation(),$o->getDateEnvoi(), $o->getEtat(), $o->getId())) or die('Error');
    
        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un retour de vente",'update',null,$old,$new));

    }

    public function updateEtat($o) {

        $query = "UPDATE RetourVente SET etat=?,date_envoi=? where id = ?";

        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getEtat(),$o->getDateEnvoi(), $o->getId())) or die('Error');
    
        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un retour de vente",'update',null,$old,$new));

    }
    /* Mohammed Amine AYACHE Added : */
    public function LastID() {

        $query = "SELECT MAX(id) as Max FROM RetourVente";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }
    /* End Adding */

}
