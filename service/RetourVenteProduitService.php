<?php

include_once 'beans/RetourVenteProduit.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

include_once 'service/RetourVenteService.php';

class RetourVenteProduitService implements IDao
{

    private $connexion;
    private $watch;
            

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();

    }



    public function create($o) {

        $query = "INSERT INTO RetourVenteProduit (`retour`, `produit`, `prix`, `quantite`, `remise`) VALUES (?,?,?,?,?); UPDATE Produit set quantite_en_stock = quantite_en_stock + ? where reference = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getRetour(),$o->getProduit(),$o->getPrix(),$o->getQuantite(),$o->getRemise(),$o->getQuantite(),$o->getProduit())) or die('Error');
        
        $req->closeCursor();
        
        $new = json_encode($this->findById($o));
        
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau produit dans un retour de vente",'add',null,null,$new));

    }

    public function addMany($o) {
        $r= true;

        try {
            $query = "INSERT INTO RetourVente (client,date_creation,date_envoi,etat,bon) VALUES (?,?,?,?,?);";
            $req = $this->connexion->getConnexion()->prepare($query);
            $req->execute(array($o['client'],date('Y-m-d'),"","En attente",$o['bon'])) or $r=false;

        } catch (Exception $e) {
            $r=false;
        }

        $query = "select last_insert_id() as id;";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array()) or die('Error');
        $res = $req->fetch(PDO::FETCH_OBJ);
        $id = $res->id;
        $req->closeCursor();
        $rs = new RetourVenteService();
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau retour de vente",'add',null,null,json_encode($rs->findById($id))));


        if($r==false)
            return $r;

        try {
            foreach ($o['data'] as $d){
                $query = "INSERT INTO RetourVenteProduit (`retour`, `produit`, `prix`, `quantite`, `remise`) VALUES (?,?,?,?,?); UPDATE Produit set quantite_en_stock = quantite_en_stock + ? where reference = ?";
                $req = $this->connexion->getConnexion()->prepare($query);
                $req->execute(array($id,$d['produit'],$d['prix'],$d['quantite'],$d['remise'],$d['quantite'],$d['produit'])) or $r=false;
                $req->closeCursor();
                $new = json_encode($this->findById(new RetourVenteProduit($id,$d['produit'],$d['prix'],$d['quantite'],$d['remise'])));
                $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau produit dans un retour de vente",'add',null,null,$new));
            }
        } catch (Exception $e) {
            $r=false;
        }


        if($r == false)
        {
            $query = "DELETE FROM RetourVente where id = ?";
            $req = $this->connexion->getConnexion()->prepare($query);
            $req->execute(array($id)) or $r=false;

        }

        return $r;

    }

    public function delete($o) {

        $query = "DELETE FROM RetourVenteProduit WHERE retour = ? and produit = ?; UPDATE Produit set quantite_en_stock = quantite_en_stock - ? where reference = ?";

        $req = $this->connexion->getConnexion()->prepare($query);
    
        $old = json_encode($this->findById($o));

        $req->execute(array($o->getRetour(),$o->getProduit(),$o->getQuantite(),$o->getProduit())) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un produit du retour de vente", 'delete', null, $old, null));

    }



    public function findAll() {

        $query = "SELECT * from RetourVenteProduit";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;

    }

    public function findByRetour($id) {

        $query = "SELECT d.*,p.designation_vente,p.designation_achat,(d.prix-(d.prix*d.remise/100))*d.quantite as total_ht,d.tva,((d.prix-(d.prix*d.remise/100))*d.quantite*(d.tva/100))+((d.prix-(d.prix*d.remise/100))*d.quantite) as total_ttc,p.unite_principale as unite,d.remise FROM RetourVenteProduit d inner join Produit p on p.reference = d.produit where retour =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findById($o) {

        $query = "SELECT * from RetourVenteProduit where retour =? and produit = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getRetour(),$o->getProduit()));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE RetourVenteProduit SET prix=?,quantite=?,remise=? where retour=? and produit=?; UPDATE Produit set quantite_en_stock = quantite_en_stock + ? where reference = ?";

        $old = json_encode($this->findById($o[0]));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o[0]->getPrix(),$o[0]->getQuantite(),$o[0]->getRemise(),$o[0]->getRetour(),$o[0]->getProduit(),$o[1],$o[0]->getProduit())) or die('Error');
        
        $req->closeCursor();
        
        $new = json_encode($this->findById($o[0]));
        
        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un produit du retour de vente",'update',null,$old,$new));

    }	/* Mohammed Amine Added */	public function getReturnedProductsOrders() {        $query = "SELECT produit, SUM(quantite) as total from RetourVenteProduit GROUP BY produit ORDER BY SUM(quantite) DESC LIMIT 10 ";		$req = $this->connexion->getConnexion()->query($query);        $total = $req->fetchAll(PDO::FETCH_OBJ);        return $total;    }	/* End adding */

}