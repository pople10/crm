<?php

include_once 'beans/AvoirAchatProduit.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';


class AvoirAchatProduitService implements IDao
{

    private $connexion;
    private $watch;



    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();

    }



    public function create($o) {

        $query = "INSERT INTO AvoirAchatProduit (`avoir`, `produit`, `prix`, `quantite`) VALUES (?,?,?,?)/*; UPDATE Produit set quantite_en_stock = quantite_en_stock + ? where reference = ?*/";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getAvoir(),$o->getProduit(),$o->getPrix(),$o->getQuantite()/*,$o->getQuantite(),$o->getProduit()*/)) or die('Error');
        
        $req->closeCursor();
        
        $new = json_encode($this->findById($o));
        
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau produit dans un avoir d'achat",'add',null,null,$new));

    }



    public function delete($o) {

        $query = "DELETE FROM AvoirAchatProduit WHERE avoir = ? and produit = ?/*; UPDATE Produit set quantite_en_stock = quantite_en_stock - ? where reference = ?*/";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o));
        
        $req->execute(array($o->getAvoir(),$o->getProduit()/*,$o->getQuantite(),$o->getProduit()*/)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un produit d'avoir d'achat", 'delete', null, $old, null));
    }



    public function findAll() {

        $query = "SELECT * from AvoirAchatProduit";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;

    }

    public function findByAvoir($id) {

        $query = "SELECT d.*,p.designation_vente,p.designation_achat,d.prix*d.quantite as total_ht,d.tva,(d.prix*d.quantite*(d.tva/100))+(d.prix*d.quantite) as total_ttc,p.unite_principale as unite FROM AvoirAchatProduit d inner join Produit p on p.reference = d.produit where avoir =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findById($o) {

        $query = "SELECT * from AvoirAchatProduit where avoir =? and produit = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getAvoir(),$o->getProduit()));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE AvoirAchatProduit SET prix=?,quantite=? where avoir=? and produit=?/*; UPDATE Produit set quantite_en_stock = quantite_en_stock + ? where reference = ?*/";
        
         $old = json_encode($this->findById($o[0]));
         
        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o[0]->getPrix(),$o[0]->getQuantite(),$o[0]->getAvoir(),$o[0]->getProduit()/*,$o[1],$o[0]->getProduit()*/)) or die('Error');
        
        $req->closeCursor();
        
        $new = json_encode($this->findById($o[0]));
        
        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un produit d'avoir d'achat",'update',null,$old,$new));

    }

}