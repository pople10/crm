<?php

include_once 'beans/HistoriqueAction.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';

class HistoriqueActionService implements IDao {

    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function create($o) {
        $query = "INSERT INTO HistoriqueAction VALUES (NULL,NOW(),?,?,?,?,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getAction(),$o->getType(),$_SESSION['user_id'],$o->getOld(),$o->getNew())) or die('Error');
        $req->closeCursor();
    }

    public function delete($o) {
        $query = "DELETE FROM HistoriqueAction WHERE id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o)) or die("erreur delete");
        $req->closeCursor();
    }

    public function findAll() {
        $query = "select H.*,U.nom as username from HistoriqueAction H inner join User U on H.user = U.id order by H.id desc";
        $req = $this->connexion->getConnexion()->query($query);
        $actions = $req->fetchAll(PDO::FETCH_OBJ);
        return $actions;
    }

    public function findById($id) {
        $query = "select H.*,U.nom as username from HistoriqueAction H inner join User U on H.user = U.id where H.id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
//        $query = "UPDATE HistoriqueAction SET nom = ? , prenom = ? , civilite = ? , type= ? , adresse= ? , cp= ? , ville= ? , pays= ? , ice= ? , codeIf= ? , telephone= ? , gsm= ? , fax= ? , email= ? , web= ? , reglement= ? , note= ? , text1= ? , text2= ? , text3= ? , dateCreation= ? , categorie= ? , suivi= ? , recouvreur= ? , activite= ? , region= ? , origine= ? , devise= ? , compteTiers= ? , compteComptable= ? ,  charge= ? where id = ?";
//        $req = $this->connexion->getConnexion()->prepare($query);
//        $req->execute(array($o->getNom(), $o->getPrenom(), $o->getCivilite(), $o->getType(), $o->getAdresse(), $o->getCp(), $o->getVille(), $o->getPays(), $o->getIce(), $o->getCodeIf(), $o->getTelephone(), $o->getGsm(), $o->getFax(), $o->getEmail(), $o->getWeb(), $o->getReglement(), $o->getNote(), $o->getText1(), $o->getText2(), $o->getText3(), $o->getDateCreation(), $o->getCategorie(), $o->getSuivi(), $o->getRecouvreur(), $o->getActivite(), $o->getRegion(), $o->getOrigine(), $o->getDevise(), $o->getCompteTiers(), $o->getCompteComptable(), $o->getCharge(), $o->getId())) or die('Error');
    }



}
