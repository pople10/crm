<?php

include_once 'beans/Fournisseur.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
include_once 'service/HistoriqueActionService.php';

class FournisseurService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {
        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {
        $query = "INSERT INTO Fournisseur VALUES (NULL,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom(), $o->getPrenom(), $o->getCivilite(), $o->getType(), $o->getAdresse(), $o->getCp(), $o->getVille(), $o->getPays(), $o->getIce(), $o->getCodeIf(), $o->getTelephone(), $o->getGsm(), $o->getFax(), $o->getEmail(), $o->getWeb(), $o->getReglement(), $o->getNote(), $o->getText1(), $o->getText2(), $o->getText3(), $o->getDateCreation(), $o->getCategorie(), $o->getSuivi(), $o->getRecouvreur(), $o->getActivite(), $o->getRegion(), $o->getOrigine(), $o->getDevise(), $o->getCompteTiers(), $o->getCompteComptable(), $o->getCharge())) or die('Error');
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau fournisseur",'add',null,null,json_encode($this->getLastInserted())));
    }

    public function delete($o) {
        $query = "DELETE FROM Fournisseur WHERE id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($o));
        $req->execute(array($o)) or die("erreur delete");
        $this->watch->create(new HistoriqueAction(null,null,"Suppression d'un fournisseur",'delete',null,$old,null));
    }

    public function getLastInserted()
    {
        $query = "select * from Fournisseur where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

        public function findAll() {
        $query = "select * from Fournisseur";
        $req = $this->connexion->getConnexion()->query($query);
        $fournisseurs = $req->fetchAll(PDO::FETCH_OBJ);
        return $fournisseurs;
    }

    public function findById($id) {
        $query = "select * from Fournisseur where id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
        $query = "UPDATE Fournisseur SET nom = ? , prenom = ? , civilite = ? , type= ? , adresse= ? , cp= ? , ville= ? , pays= ? , ice= ? , codeIf= ? , telephone= ? , gsm= ? , fax= ? , email= ? , web= ? , reglement= ? , note= ? , text1= ? , text2= ? , text3= ? , dateCreation= ? , categorie= ? , suivi= ? , recouvreur= ? , activite= ? , region= ? , origine= ? , devise= ? , compteTiers= ? , compteComptable= ? ,  charge= ? where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $old = json_encode($this->findById($o->getId()));
        $req->execute(array($o->getNom(), $o->getPrenom(), $o->getCivilite(), $o->getType(), $o->getAdresse(), $o->getCp(), $o->getVille(), $o->getPays(), $o->getIce(), $o->getCodeIf(), $o->getTelephone(), $o->getGsm(), $o->getFax(), $o->getEmail(), $o->getWeb(), $o->getReglement(), $o->getNote(), $o->getText1(), $o->getText2(), $o->getText3(), $o->getDateCreation(), $o->getCategorie(), $o->getSuivi(), $o->getRecouvreur(), $o->getActivite(), $o->getRegion(), $o->getOrigine(), $o->getDevise(), $o->getCompteTiers(), $o->getCompteComptable(), $o->getCharge(), $o->getId())) or die('Error');
        $new = json_encode($this->findById($o->getId()));
        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un fournisseur",'update',null,$old,$new));
    }

    public function findMontantFournisseur() {
        $query = "select CONCAT(f.nom,' ', f.prenom) as nom, SUM(ca.prix*ca.quantite) as montant from Fournisseur f inner JOIN BonAchat c on f.id = c.fournisseur INNER JOIN BonAchatProduit ca on ca.bon = c.id group BY nom ORDER by montant DESC LIMIT 10";
        $req = $this->connexion->getConnexion()->query($query);
        $fournisseurs = $req->fetchAll(PDO::FETCH_OBJ);
        return $fournisseurs;
    }

}
