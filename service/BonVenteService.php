<?php

include_once 'beans/BonVente.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class BonVenteService Implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO BonVente (client,date,etat,commande, receptionner_par) VALUES (?,?,?,NULL,?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getClient(), $o->getDate(), $o->getEtat(),$o->getReceptionner_par())) or die('Error');

        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau bon de livraison de vente",'add',null,null,json_encode($this->getLastInserted())));
    }

    public function getLastInserted()
    {
        $query = "select * from BonVente where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($id) {

        $query = "DELETE FROM BonVente WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un bon de livraison de vente", 'delete', null, $old, null));
    }

    public function findAll() {

        $query = "Select * from BonVenteView";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }

    public function findById($id) {

        $query = "SELECT * from BonVente where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function getLastPrice($produit) {

//        $query = "SELECT * FROM BonVenteProduit bap inner join BonVente ba on ba.id = bap.bon where ba.client in (select b.Client from BonVente b where b.id = ?) and bap.produit = ? order by ba.id desc LIMIT 1";

        $query = "select MAX(bap.prix)*2 as prix from BonAchatProduit bap where bap.produit = ?";
        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function findTotalByYear() {
        $query = "SELECT sum(prix*quantite) as total from BonVenteProduit bvp
                inner join BonVente bv
                on bv.id = bvp.bon
                where year(bv.date) = year(NOW())";
        
        $req = $this->connexion->getConnexion()->query($query);

        $total = $req->fetch(PDO::FETCH_OBJ);

        return $total;
    }
    
    public function findTotalByYear1() {
        $query = "SELECT sum(total_ht + tva) as total from BonVente WHERE 1";
        
        $req = $this->connexion->getConnexion()->query($query);

        $total = $req->fetch(PDO::FETCH_OBJ);

        return $total;
    }
    
    public function findTotalByMonth() {

        $query = "SELECT month(date) as mois, SUM(bap.prix * bap.quantite) as total FROM BonVente ab inner join BonVenteProduit bap on ab.id = bap.bon where year(date) = year(NOW()) GROUP by month(date)";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }
    
    public function findTotalByMonth1() {

        $query = "SELECT month(date) as mois, SUM(total_ht + tva) as total FROM BonVente where year(date) = year(NOW()) GROUP by month(date)";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }

    public function update($o) {

        $query = "UPDATE BonVente SET client=?,date=?,etat=?,receptionner_par=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getClient(), $o->getDate(), $o->getEtat(),$o->getReceptionner_par(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un bon de livraison de vente",'update',null,$old,$new));
    }

    public function updateEtat($o) {

        $query = "UPDATE BonVente SET etat=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));
        
        $req->execute(array($o->getEtat(), $o->getId())) or die('Error');
        
        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un bon de livraison de vente",'update',null,$old,$new));
    }
/* Mohammed Amine Added this : */	

    public function findTotalByYears() {        
        $query = "SELECT year(date) as year,month(date) as month, SUM(total_ht + tva) as total FROM BonVente					
        where 1					
        GROUP by DATE_FORMAT(date,'%Y-%m') DESC";                
        $req = $this->connexion->getConnexion()->query($query);        
        $all = $req->fetchAll(PDO::FETCH_OBJ);        return $all;    
        
    }	
    public function findNonFacture()	{		
        $query="SELECT COUNT(id) as totalnonfacture, sum(total_ht+tva) as total from BonVente bv WHERE bv.id NOT IN (SELECT bon FROM FactureVente WHERE bon<>NULL)";		
        $req = $this->connexion->getConnexion()->query($query);        
        $all = $req->fetchAll(PDO::FETCH_OBJ);        
        return $all;	
        
    }		
    public function ProductsSoldFundsByMonth($year) {        
        $query = "SELECT SUM(quantite*prix) as total,designation_vente as title,produit as code,year(date) as year ,month(date) as month FROM BonVenteProduit bvp 	
        inner join BonVente bv on bv.id = bvp.bon inner join Produit p on p.reference=bvp.produit 	
        WHERE year(date)='$year' GROUP BY `produit`,month(date)";   
        $req = $this->connexion->getConnexion()->query($query);     
        $all = $req->fetchAll(PDO::FETCH_OBJ);        
        return $all;
        }
	
	public function getAllProductsNameAndCodes() {

        $query = "SELECT designation_vente as title,produit as code FROM BonVenteProduit bvp 
					inner join Produit p on p.reference=bvp.produit 
					WHERE 1 GROUP BY p.reference";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }
    public function CountUndeliveredOrders() {  
        $query = "SELECT count(*) as nbr          
        from BonVente c           
        where c.etat = 'Non Livré'";   
        $req = $this->connexion->getConnexion()->query($query);   
        $total = $req->fetchAll(PDO::FETCH_OBJ);    
        return $total;  
    }	
	public function CountDeliveredOrders() {

        $query = "SELECT count(*) as nbr

            from BonVente c 

            where c.etat = 'Livré'";
        $req = $this->connexion->getConnexion()->query($query);
        $total = $req->fetchAll(PDO::FETCH_OBJ);
        return $total;

    }
    public function FactureImpayé()
    {
        $query = "SELECT count(*) as nbr, SUM(total_ht +tva) as total       
        from FactureVente fv          
        where fv.type = 'Non réglée'";   
        $req = $this->connexion->getConnexion()->query($query);   
        $total = $req->fetchAll(PDO::FETCH_OBJ);    
        return $total;  
    }
    public function FacturePayé()
    {
        $query = "SELECT count(*) as nbr, SUM(total_ht +tva) as total       
        from FactureVente fv          
        where fv.type = 'Réglée'";   
        $req = $this->connexion->getConnexion()->query($query);   
        $total = $req->fetchAll(PDO::FETCH_OBJ);    
        return $total;  
    }
    public function LastID()
    {
        $query = "SELECT MAX(id) as Max FROM BonVente WHERE 1";   
        $req = $this->connexion->getConnexion()->query($query);   
        $total = $req->fetchAll(PDO::FETCH_OBJ);    
        return $total;  
    }
    /* End adding */
}
