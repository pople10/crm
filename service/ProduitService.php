<?php

include_once 'beans/Produit.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class ProduitService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO Produit(reference,designation_vente,designation_achat,appellation,description,image,tarif_ht,tva,tarif_ttc,en_promotion,enp_de,enp_au,prix_promo,remise_n1,remise_n2,remise_n3,remise_n4,categorie,famille,marque,gere_en_stock,quantite_en_stock,stock_alerte,quantite_max,unite_principale,unite_vente,c_longueur,c_largeur,c_epaisseur,statut) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getReference(), $o->getDesignation_vente(), $o->getDesignation_achat(),$o->getAppellation() ,$o->getDescription(), $o->getImage(), $o->getTarif_ht(), $o->getTva(), $o->getTarif_ttc(), $o->getEn_promotion(), $o->getEnp_de(), $o->getEnp_au(), $o->getPrix_promo(), $o->getRemise_n1(), $o->getRemise_n2(), $o->getRemise_n3(), $o->getRemise_n4(), $o->getCategorie(), $o->getFamille(), $o->getMarque(), $o->getGere_en_stock(), $o->getQuantiteEnStock(), $o->getStock_alerte(), $o->getQuantiteMax(), $o->getUnite_principale(), $o->getUnite_vente(), $o->getC_longueur(), $o->getC_largeur(), $o->getC_epaisseur(), $o->getStatut())) or die('Error');

        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'un nouveau produit", 'add', null, null, json_encode($this->findById($o->getReference()))));
    }

    public function delete($ref) {

        $query = "DELETE FROM Produit WHERE reference = ?";

        $old = json_encode($this->findById($ref));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($ref)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un produit", 'delete', null, $old, null));
    }

    public function findAll() {

        //$query = "SELECT p.*,c.code as 'categorie_code',m.nom as 'marque_nom',f.nom as 'famille_nom',sf.nom as 'sfamille_nom' FROM Produit p inner join Categorie c on c.id=p.categorie inner JOIN Marque m on m.id=p.marque inner JOIN Famille f on f.id=p.famille INNER join Famille sf on sf.id = p.sous_famille";
        $query = "SELECT p.* FROM Produit p";


        $req = $this->connexion->getConnexion()->query($query);

        $produits = $req->fetchAll(PDO::FETCH_OBJ);

        return $produits;
    }

    public function findAllAlertes() {

        $query = "SELECT * from Produit P where P.quantite_en_stock <= P.stock_alerte";


        $req = $this->connexion->getConnexion()->query($query);

        $produits = $req->fetchAll(PDO::FETCH_OBJ);

        return $produits;
    }

    public function findById($reference) {

        $query = "SELECT *,(quantite_max - quantite_en_stock) as quantite_max_c from Produit where reference =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($reference));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }


    private function replaceAll($str){
        $str = str_replace(array("+","|","?","(",")","[","]","$","*",".","^","\\"), array("\\+","\\|","\\?","\\(","\\)","\\[","\\]","\\$","\\*","\\.","\\^","\\\\"), $str);
					     
         $args = explode(' ',$str);
         $str = "";
         for($i = 0, $size = count($args); $i < $size; ++$i) {
            $str .= "(?=.*".$args[$i].")";
        }
        
        return $str;
    }
    
    public function findAllByDevis($devis,$q) {

        
        
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM DevisAchatProduit d where d.devis = ?) '.$q.' LIMIT 100';

        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM DevisAchatProduit d where d.devis = ?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($devis));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByBon($bon,$q) {
        
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM BonAchatProduit d where d.bon = ?) '.$q.' LIMIT 100';


        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM BonAchatProduit d where d.bon = ?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($bon));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByRetour($retour,$q) {
        
            
            
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM RetourAchatProduit d where d.retour = ?) '.$q.' LIMIT 100';


        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM RetourAchatProduit d where d.retour = ?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($retour));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByFacture($facture,$q) {

        
        
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM FactureAchatProduit d where d.facture = ?) '.$q.' LIMIT 100';


        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM FactureAchatProduit d where d.facture = ?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($facture));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByAvoir($avoir,$q) {

        
        
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM AvoirAchatProduit d where d.avoir = ?) '.$q.' LIMIT 100';


        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM AvoirAchatProduit d where d.avoir = ?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($avoir));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByCommande($commande,$q) {

        
        
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM CommandeAchatProduit d where d.commande = ?) '.$q.' LIMIT 100';


        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM CommandeAchatProduit d where d.commande = ?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($commande));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByDevisVente($devis,$q) {
        
            
            
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM DevisVenteProduit d where d.devis = ?) and p.quantite_en_stock != 0 '.$q.' LIMIT 100';

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($devis));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByBonVente($bon,$q) {
        
            
            
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM BonVenteProduit d where d.bon = ?) and p.quantite_en_stock != 0 '.$q.' LIMIT 100';


        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM BonVenteProduit d where d.bon = ?) and p.quantite_en_stock != 0";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($bon));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByRetourVente($retour,$q) {
        
            
            
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM RetourVenteProduit d where d.retour = ?) and p.quantite_en_stock != 0 '.$q.' LIMIT 100';

        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM RetourVenteProduit d where d.retour = ?) and p.quantite_en_stock != 0";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($retour));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByFactureVente($facture,$q) {
        
            
            
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM FactureVenteProduit d where d.facture = ?) and p.quantite_en_stock != 0 '.$q.' LIMIT 100';
        
        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM FactureVenteProduit d where d.facture = ?) and p.quantite_en_stock != 0";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($facture));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByAvoirVente($avoir,$q) {
        
            
            
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM AvoirVenteProduit d where d.avoir = ?) and p.quantite_en_stock != 0 '.$q.' LIMIT 100';

        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM AvoirVenteProduit d where d.avoir = ?) and p.quantite_en_stock != 0";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($avoir));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByCommandeVente($commande,$q) {

        
        
        $q = ' and CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") REGEXP "'.$this->replaceAll($q).'"';

        $query = 'SELECT *, CONCAT(IF(p.designation_vente is null or p.designation_vente ="", p.designation_achat , p.designation_vente), " ( Quantité : ",p.quantite_en_stock, " " , p.unite_principale , " )") as _designation from Produit p where p.reference not in (select d.produit FROM CommandeVenteProduit d where d.commande = ?) and p.quantite_en_stock != 0 '.$q.' LIMIT 100';
        
        //$query = "SELECT * from Produit p where p.reference not in (select d.produit FROM CommandeVenteProduit d where d.commande = ?) and p.quantite_en_stock != 0";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($commande));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function findPurchasedProduct() {
        $query = "select p.reference, c.quantite from Produit p inner join 
                BonAchatProduit c 
                on c.produit = p.reference
                GROUP BY p.reference
                ORDER by c.quantite DESC
                LIMIT 15";
        $req = $this->connexion->getConnexion()->query($query);

        $produits = $req->fetchAll(PDO::FETCH_OBJ);

        return $produits;
    }

    public function findCount(){
            $req = "SELECT count(*) FROM Produit"; 
	    $result  = $this->connexion->getConnexion()->query($req); 
            $number_of_rows = $result->fetchColumn(); 
	    return $number_of_rows;
    }
    public function update($o) {

        $query = "UPDATE Produit SET designation_vente=?,designation_achat=?,appellation=?,description=?,image=?,tarif_ht=?,tva=?,tarif_ttc=?,en_promotion=?,enp_de=?,enp_au=?,prix_promo=?,remise_n1=?,remise_n2=?,remise_n3=?,remise_n4=?,categorie=?,famille=?,marque=?,gere_en_stock=?,quantite_en_stock=?,stock_alerte=?,quantite_max=?,unite_principale=?,unite_vente=?,c_longueur=?,c_largeur=?,c_epaisseur=?,statut=? where reference=?";

        $old = json_encode($this->findById($o->getReference()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getDesignation_vente(), $o->getDesignation_achat(),$o->getAppellation() ,$o->getDescription(), $o->getImage(), $o->getTarif_ht(), $o->getTva(), $o->getTarif_ttc(), $o->getEn_promotion(), $o->getEnp_de(), $o->getEnp_au(), $o->getPrix_promo(), $o->getRemise_n1(), $o->getRemise_n2(), $o->getRemise_n3(), $o->getRemise_n4(), $o->getCategorie(), $o->getFamille(), $o->getMarque(), $o->getGere_en_stock(), $o->getQuantiteEnStock(), $o->getStock_alerte(), $o->getQuantiteMax(), $o->getUnite_principale(), $o->getUnite_vente(), $o->getC_longueur(), $o->getC_largeur(), $o->getC_epaisseur(), $o->getStatut(), $o->getReference())) or die('Error');
    
        $new = json_encode($this->findById($o->getReference()));
        
        $this->watch->create(new HistoriqueAction(null, null, "Modification d'un produit", 'update', null, $old, $new));
    }
    
    public function findTop10SoldProducts() {
        $query = "select p.reference,p.designation_vente,SUM(c.quantite*c.prix) as total from Produit p inner join 
                BonVenteProduit c 
                on c.produit = p.reference
                GROUP BY p.reference
                ORDER by c.quantite*c.prix DESC
                LIMIT 10";
        $req = $this->connexion->getConnexion()->query($query);
        $clients = $req->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }

}
