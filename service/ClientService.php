<?php

include_once 'beans/Client.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
include_once 'service/HistoriqueActionService.php';


class ClientService implements IDao {

    private $connexion;
    private $watch;
    function __construct() {
        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO Client (`nom`, `prenom`, `civilite`, `type`, `adresse`, `cp`, `ville`, `pays`, `ice`, `codeIf`, `telephone`, `gsm`, `fax`, `email`, `web`, `reglement`, `mode`, `dateCreation`, `categorie`, `suivi`, `recouvreur`, `activite`, `region`, `origine`, `devise`, `compteTiers`, `compteComptable`, `plafond`, `plafondEmpye`, `douteux`,`dateLimit`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $req = $this->connexion->getConnexion()->prepare($query);
        $vars = array($o->getNom(), $o->getPrenom(), $o->getCivilite(), $o->getType(), $o->getAdresse(), $o->getCp(), $o->getVille(), $o->getPays(), $o->getIce(), $o->getCodeIf(), $o->getTelephone(), $o->getGsm(), $o->getFax(), $o->getEmail(), $o->getWeb(), $o->getReglement(), $o->getMode(), $o->getDateCreation(), $o->getCategorie(), $o->getSuivi(), $o->getRecouvreur(), $o->getActivite(), $o->getRegion(), $o->getOrigine(), $o->getDevise(), $o->getCompteTiers(), $o->getCompteComptable(), $o->getPlafond(), $o->getPlafondEmpye(), $o->getDouteux(),$o->getDateLimit());
        $req->execute($vars) or die('Error');
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau client",'add',null,null,json_encode($this->getLastInserted())));
    }

    public function delete($o) {
        $query = "DELETE FROM Client WHERE id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($o));
        $req->execute(array($o)) or die("erreur delete");
        $this->watch->create(new HistoriqueAction(null,null,"Suppression d'un client",'delete',null,$old,null));
    }

    public function findAll() {
        $query = "select * from Client WHERE etat<>'bloqué' OR etat IS NULL";
        $req = $this->connexion->getConnexion()->query($query);
        $clients = $req->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }

    public function findMontantClient() {
        $query = "select CONCAT(c.nom,' ', c.prenom) as nom, SUM(bvp.prix * bvp.quantite) as montant from Client c inner JOIN BonVente b on c.id = b.client INNER JOIN BonVenteProduit bvp on b.id = bvp.bon group BY nom ORDER by montant DESC LIMIT 10";
        $req = $this->connexion->getConnexion()->query($query);
        $clients = $req->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }

    public function findSoldProducts() {
        $query = "select p.reference, c.quantite from Produit p inner join 
                BonVenteProduit c 
                on c.produit = p.reference
                GROUP BY p.reference
                ORDER by c.quantite DESC
                LIMIT 30";
        $req = $this->connexion->getConnexion()->query($query);
        $clients = $req->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }
    public function getLastInserted() {
        $query = "select * from Client where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function findById($id) {
        $query = "select * from Client where id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }
    
     public function getComptes($dateD,$dateF,$client) {
        $query = "select * from comptesClient where IF(? != '' and ? != '' , date BETWEEN CONVERT(?,DATE) and CONVERT(?,DATE) , 1=1) and client = ? and total_ttc is not null order by date desc";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($dateD,$dateF,$dateD,$dateF,$client));
        $res = $req->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
    
    public function getAllClientsCompte($client) {
            $c = "";
            if(is_numeric($client))
                $c = " where cc.client = ".$client;
            //$query = "select cc.*, CONCAT(c.nom,' ',c.prenom) as nom from comptesClient cc INNER join Client c on c.id=cc.client where cc.total_ttc is not null ".$c." order by cc.date desc";
            $query = "select c.id as code,CONCAT(c.nom,' ',c.prenom) as nom,(Select max(date) from comptesClient where client = cc.client) as date , (SELECT IF(SUM(total_ttc) is null ,0, SUM(total_ttc)) from comptesClient where client = cc.client and ( tablename like 'livraison' or tablename like 'reglement.avoir.%' ) and total_ttc is not null) as debit, (SELECT IF(SUM(total_ttc) is null ,0, SUM(total_ttc)) from comptesClient where client = cc.client and ( tablename like 'retour' or tablename like 'reglement.facture.%' ) and total_ttc is not null) as credit , (SELECT IF(SUM(total_ttc) is null ,0, SUM(total_ttc))  from comptesClient where client = cc.client and ( tablename like 'retour' or tablename like 'reglement.facture.%' ) and total_ttc is not null) - (SELECT IF(SUM(total_ttc) is null ,0, SUM(total_ttc)) from comptesClient where client = cc.client and ( tablename like 'livraison' or tablename like 'reglement.avoir.%' ) and total_ttc is not null) as solde from comptesClient cc INNER join Client c on c.id=cc.client ".$c." GROUP by cc.client";
            $req = $this->connexion->getConnexion()->prepare($query);
            $req->execute();
            $res = $req->fetchAll(PDO::FETCH_OBJ);
            return $res;
        }
    public function update($o) {
        $query = "UPDATE Client SET nom = ? , prenom = ? , civilite = ? , type= ? , adresse= ? , cp= ? , ville= ? , pays= ? , ice= ? , codeIf= ? , telephone= ? , gsm= ? , fax= ? , email= ? , web= ? , reglement= ? , mode= ? , dateCreation= ? , categorie= ? , suivi= ? , recouvreur= ? , activite= ? , region= ? , origine= ? , devise= ? , compteTiers= ? , compteComptable= ? , plafond= ? , plafondEmpye= ? , douteux= ? , dateLimit=? where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($o->getId()));
        $req->execute(array($o->getNom(), $o->getPrenom(), $o->getCivilite(), $o->getType(), $o->getAdresse(), $o->getCp(), $o->getVille(), $o->getPays(), $o->getIce(), $o->getCodeIf(), $o->getTelephone(), $o->getGsm(), $o->getFax(), $o->getEmail(), $o->getWeb(), $o->getReglement(), $o->getMode(), $o->getDateCreation(), $o->getCategorie(), $o->getSuivi(), $o->getRecouvreur(), $o->getActivite(), $o->getRegion(), $o->getOrigine(), $o->getDevise(), $o->getCompteTiers(), $o->getCompteComptable(), $o->getPlafond(), $o->getPlafondEmpye(), $o->getDouteux(),$o->getDateLimit(), $o->getId())) or die('Error');
        $new = json_encode($this->findById($o->getId()));
        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un client",'update',null,$old,$new));
    }
	/* Mohammed Amine Added the following code : */	
	public function findMontantClientAndID() {        
	    $query = "select c.id as id , c.nom as nom, 
	    SUM(bv.total_ht + bv.tva) as montant from Client c 
	    inner JOIN BonVente bv on c.id = bv.client 
	    group BY c.id ORDER by montant DESC LIMIT 10";        
	    $req = $this->connexion->getConnexion()->query($query);        
	    $clients = $req->fetchAll(PDO::FETCH_OBJ);        
	    return $clients;    
	    
	}
    public function updateMode($id,$mode)
    {
        $query="UPDATE Client SET mode= ? WHERE id= ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($id));
        $req->execute(array($mode,$id)) or die('Error');
        $new = json_encode($this->findById($id));
        $this->watch->create(new HistoriqueAction(null,null,"Modification du mode réglement d'un client",'update',null,$old,$new));
    }
    public function getAlertedClients()
    {
        $query="SELECT id,nom,prenom,plafond,plafondEmpye,etat FROM Client WHERE plafond<=plafondEmpye";
        $req = $this->connexion->getConnexion()->query($query);
        $clients = $req->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }
    public function updateEtat($id,$etat,$dateLimit)
    {   
        $query="UPDATE Client SET etat= ?,dateLimit=? WHERE id= ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($id));
        $req->execute(array($etat,$dateLimit,$id)) or die('Error');
        $new = json_encode($this->findById($id));
        if($etat=="bloqué")
        $this->watch->create(new HistoriqueAction(null,null,"Blocage d'un client",'update',null,$old,$new));
        else
        $this->watch->create(new HistoriqueAction(null,null,"Déblocage d'un client",'update',null,$old,$new));
    }
    public function getBlackListed()
    {
        $query="SELECT * FROM Client WHERE etat='bloqué'";
        $req = $this->connexion->getConnexion()->query($query);
        $clients = $req->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }
    public function updateAllRemises($max)
    {
        $query="UPDATE Client SET web= ? WHERE web>?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($max,$max)) or die('Error');
        
    }
    public function BlackListByLimitDate()
    {
        $query="UPDATE Client SET etat='bloqué' WHERE dateLimit<=date(NOW()) AND dateLimit<>'0000-00-00'";
        $req = $this->connexion->getConnexion()->query($query) or die('Error');
    }
	/* end adding */
}
