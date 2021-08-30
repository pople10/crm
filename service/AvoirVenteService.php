<?php

include_once 'beans/AvoirVente.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class AvoirVenteService Implements IDao {

    private $connexion;
    private $watch;



    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();

    }



    public function create($o) {

        $query = "INSERT INTO AvoirVente (client,date,type,bon) VALUES (?, ?,?,NULL)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getClient(), $o->getDate(), $o->getType())) or die('Error');

        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau avoir de vente",'add',null,null,json_encode($this->getLastInserted())));
  
    }

    public function getLastInserted(){
        $query = "select * from AvoirVente where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($id) {

        $query = "DELETE FROM AvoirVente WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or die("erreur delete");
        
        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un avoir de vente", 'delete', null, $old, null));


    }



    public function findAll() {

        $query = "Select * from AvoirVenteView";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;

    }



    public function findById($id) {

        $query = "SELECT * from AvoirVente where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function getLastPrice($produit) {

        //$query = "SELECT * FROM BonVenteProduit bap inner join BonVente ba on ba.id = bap.bon where ba.client in (select b.Client from AvoirVente b where b.id = ?) and bap.produit = ? order by ba.id desc LIMIT 1";
        $query = "select MAX(bap.prix)*2 as prix from BonAchatProduit bap where bap.produit = ?";
        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }


    public function update($o) {

        $query = "UPDATE AvoirVente SET client=?,date=?,type=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getClient(), $o->getDate(), $o->getType(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un avoir de vente",'update',null,$old,$new));
    }

    public function updateType($o) {

        $query = "UPDATE AvoirVente SET type=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getType(), $o->getId())) or die('Error');
        
        $new = json_encode($this->findById($o->getId()));
        
        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un avoir de vente",'update',null,$old,$new));

    }
    /* Mohammed Amine Added : */
    public function LastID() {
        
        $query = "SELECT MAX(id) as Max FROM AvoirVente";
        
        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }
    /* End Adding */


}
