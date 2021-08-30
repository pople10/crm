<?php

include_once 'beans/DevisVenteProduit.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';



class DevisVenteProduitService implements IDao {



    private $connexion;
    private $watch;



    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();

    }



    public function create($o) {

        $query = "INSERT INTO DevisVenteProduit (`devis`, `produit`, `prix`, `quantite`, `remise`) VALUES (?,?,?,?,?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getDevis(),$o->getProduit(),$o->getPrix(),$o->getQuantite(),$o->getRemise())) or die('Error');

        $req->closeCursor();
        
        $new = json_encode($this->findById($o));
        
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau produit dans un devis de vente",'add',null,null,$new));
    }



    public function delete($o) {

        $query = "DELETE FROM DevisVenteProduit WHERE devis = ? and produit = ?";

        $req = $this->connexion->getConnexion()->prepare($query);
        
        $old = json_encode($this->findById($o));

        $req->execute(array($o->getDevis(),$o->getProduit())) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un produit du devis de vente", 'delete', null, $old, null));

    }



    public function findAll() {

        $query = "SELECT * from DevisVenteProduit";

        $req = $this->connexion->getConnexion()->query($query);

        $familles = $req->fetchAll(PDO::FETCH_OBJ);

        return $familles;

    }

    public function findByDevis($id) {

        $query = "SELECT d.*,p.designation_vente,p.designation_achat,(d.prix-(d.prix*d.remise/100))*d.quantite as total_ht,d.tva,((d.prix-(d.prix*d.remise/100))*d.quantite*(d.tva/100))+((d.prix-(d.prix*d.remise/100))*d.quantite) as total_ttc,p.unite_principale as unite,d.remise FROM DevisVenteProduit d inner join Produit p on p.reference = d.produit where devis =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findById($o) {

        $query = "SELECT * from DevisVenteProduit where devis =? and produit = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getDevis(),$o->getProduit()));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE DevisVenteProduit SET prix=?,quantite=?,remise=? where devis=? and produit=?";

        $old = json_encode($this->findById($o));
                
        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getPrix(),$o->getQuantite(),$o->getRemise(),$o->getDevis(),$o->getProduit())) or die('Error');
        
        $req->closeCursor();
        
        $new = json_encode($this->findById($o));
        
        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un produit du devis de vente",'update',null,$old,$new));

    }



}

