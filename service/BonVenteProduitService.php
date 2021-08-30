<?php

include_once 'beans/BonVenteProduit.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class BonVenteProduitService implements IDao
{

    private $connexion;
    private $watch;


    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();

    }



    public function create($o) {

        $query = "INSERT INTO BonVenteProduit (`bon`, `produit`, `prix`, `quantite`, `remise`) VALUES (?,?,?,?,?); UPDATE Produit set quantite_en_stock = quantite_en_stock - ? where reference = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getBon(),$o->getProduit(),$o->getPrix(),$o->getQuantite(),$o->getRemise(),$o->getQuantite(),$o->getProduit())) or die('Error');
        
        $req->closeCursor();
        
        $new = json_encode($this->findById($o));
        
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau produit dans un bon de livraison de vente",'add',null,null,$new));

    }


    public function delete($o) {

        $query = "DELETE FROM BonVenteProduit WHERE bon = ? and produit = ?; UPDATE Produit set quantite_en_stock = quantite_en_stock + ? where reference = ?";

        $req = $this->connexion->getConnexion()->prepare($query);
        
        $old = json_encode($this->findById($o));

        $req->execute(array($o->getBon(),$o->getProduit(),$o->getQuantite(),$o->getProduit())) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un produit du bon de livraison de vente", 'delete', null, $old, null));
    }



    public function findAll() {

        $query = "SELECT * from BonVenteProduit";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;

    }

    public function findByBon($id) {

        $query = "SELECT d.*,p.designation_vente,p.designation_achat,(d.prix-(d.prix*d.remise/100))*d.quantite as total_ht,d.tva,((d.prix-(d.prix*d.remise/100))*d.quantite*(d.tva/100))+((d.prix-(d.prix*d.remise/100))*d.quantite) as total_ttc,p.unite_principale as unite,d.remise FROM BonVenteProduit d inner join Produit p on p.reference = d.produit where bon =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findById($o) {

        $query = "SELECT * from BonVenteProduit where bon =? and produit = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getBon(),$o->getProduit()));

        $res = $req->fetch(PDO::FETCH_OBJ);
                
        return $res;
    }

    public function update($o) {
        $p = $o[0];
        
        $query = "UPDATE BonVenteProduit SET prix=?,quantite=?,remise=? where bon=? and produit=?; UPDATE Produit set quantite_en_stock = quantite_en_stock - ? where reference = ?";

        $old = json_encode($this->findById($p));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($p->getPrix(),$p->getQuantite(),$p->getRemise(),$p->getBon(),$p->getProduit(),$o[1],$p->getProduit())) or die('Error');

        $req->closeCursor();
        
        $new = json_encode($this->findById($p));
        
        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un produit du bon de livraison de vente",'update',null,$old,$new));

    }

}