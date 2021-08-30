<?php

include_once 'beans/BonAchat.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';


class BonAchatService Implements IDao {

    private $connexion;
    private $watch;



    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();

    }



    public function create($o) {

        $query = "INSERT INTO BonAchat (fournisseur,date,etat,commande) VALUES (?,?,?,NULL)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getEtat())) or die('Error');
        
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau bon de réception d'achat",'add',null,null,json_encode($this->getLastInserted())));
    }

    public function getLastInserted()
    {
        $query = "select * from BonAchat where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }


    public function delete($id) {

        $query = "DELETE FROM BonAchat WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un bon de réception d'achat", 'delete', null, $old, null));

    }



    public function findAll() {

        $query = "Select * from BonAchatView";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;

    }



    public function findById($id) {

        $query = "SELECT * from BonAchat where id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function getLastPrice($bon, $produit) {

        //$query = "SELECT * FROM BonAchatProduit bap inner join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from BonAchat b where b.id = ?) and bap.produit = ? order by ba.id desc LIMIT 1";
        $query = "SELECT IF (EXISTS(SELECT @prix:=bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where ba.fournisseur in (select b.Fournisseur from BonAchat b where b.id = ?) and p.reference = ? ORDER BY ba.date DESC LIMIT 1),@prix,(SELECT bap.prix FROM BonAchatProduit bap inner JOIN Produit p on bap.produit = p.reference inner Join BonAchat ba on ba.id = bap.bon where p.reference = ? ORDER BY ba.date DESC LIMIT 1)) as prix";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($bon, $produit,$produit));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function findTotalByMonth() {

        $query = "SELECT month(date) as mois, SUM(bap.prix * bap.quantite) as total FROM BonAchat ab inner join BonAchatProduit bap on ab.id = bap.bon where year(date) = year(NOW()) GROUP by month(date)";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }
    public function findTotalByMonth1() {

        $query = "SELECT month(date) as mois, SUM(total_ht + tva) as total FROM BonAchat where year(date) = year(NOW()) GROUP by month(date)";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;
    }
    public function update($o) {

        $query = "UPDATE BonAchat SET fournisseur=?,date=?,etat=? where id = ?";

        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getFournisseur(), $o->getDate(), $o->getEtat(), $o->getId())) or die('Error');
        
         $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un bon de réception d'achat",'update',null,$old,$new));
    }

    public function updateEtat($o) {

        $query = "UPDATE BonAchat SET etat=? where id = ?";
        
        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getEtat(), $o->getId())) or die('Error');
        
        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un bon de réception d'achat",'update',null,$old,$new));
    }

    public function findTotalDepenseByYear() {
        $query = "SELECT sum(prix*quantite) as total from BonAchatProduit bvp
            inner join BonAchat bv
            on bv.id = bvp.bon
            where year(bv.date) = year(NOW())";

        $req = $this->connexion->getConnexion()->query($query);

        $total = $req->fetch(PDO::FETCH_OBJ);

        return $total;
    }
    public function findTotalDepenseByYear1() {
        $query = "SELECT sum(total_ht + tva) as total from BonAchat WHERE 1";

        $req = $this->connexion->getConnexion()->query($query);

        $total = $req->fetch(PDO::FETCH_OBJ);

        return $total;
    }
    /* Mohammed Amine Added : */	public function UninvoicedPurchasesCount() {        $query = "SELECT COUNT(*) as total from BonAchat            where etat = 'Non Facturé'";        $req = $this->connexion->getConnexion()->query($query);        $all = $req->fetch(PDO::FETCH_OBJ);        return $all;    }	
    public function findTotalAchatByYears() {        
        $query = "SELECT year(date) as year,month(date) as month, SUM(total_ht + tva ) as total FROM BonAchat			
        where 1					
        GROUP by DATE_FORMAT(date,'%Y-%m') DESC";                
        $req = $this->connexion->getConnexion()->query($query);        
        $all = $req->fetchAll(PDO::FETCH_OBJ);        
        return $all;    
    }
    public function CountUndeliveredPurchases() {        
		$query = "SELECT count(*) as nbr            
		from CommandeAchat c             
		where c.etat <> 'Livrée'";        
		$req = $this->connexion->getConnexion()->query($query);        
		$total = $req->fetchAll(PDO::FETCH_OBJ);        
		return $total;    
		}	
		public function CountFundsUndeliveredPurchases() {        
		$query = "SELECT SUM(total_ht+tva) as total            
		from CommandeAchat c 			
		where c.etat <> 'Livrée'";        
		$req = $this->connexion->getConnexion()->query($query);        
		$total = $req->fetchAll(PDO::FETCH_OBJ);        return $total;    
		}	
		public function CountDeliveredPurchases() {        
		$query = "SELECT count(*) as nbr            
		from CommandeAchat c             
		where c.etat = 'Livrée'";        
		$req = $this->connexion->getConnexion()->query($query);        
		$total = $req->fetchAll(PDO::FETCH_OBJ);        
		return $total;    
	}
	public function FactureImpayé()
    {
        $query = "SELECT count(*) as nbr, SUM(total_ht +tva) as total       
        from FactureAchat fa          
        where fa.type = 'Non réglée'";   
        $req = $this->connexion->getConnexion()->query($query);   
        $total = $req->fetchAll(PDO::FETCH_OBJ);    
        return $total;  
    }
    public function LastID()
    {
        $query = "SELECT MAX(id) as Max FROM BonAchat";   
        $req = $this->connexion->getConnexion()->query($query);   
        $total = $req->fetch(PDO::FETCH_OBJ);    
        return $total;  
    }
    /* End adding */

}
