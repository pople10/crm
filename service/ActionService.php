<?php

include_once 'beans/Action.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';

class ActionService implements IDao {

    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $fournisseur = NULL;
        $client = NULL;
        if ($o->getFournisseur() !== "") {
            $fournisseur = $o->getFournisseur();
        } else if ($o->getClient() !== "") {
            $client = $o->getClient();
        }
        $query = "INSERT INTO Action VALUES (NULL,?,?,?,?,?,?,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getDate(),
                    $o->getDateEchance(),
                    $o->getEnCharge(),
                    $o->getCommentaire(),
                    $client,
                    $fournisseur,$o->getEtat())) or die('Error');
    }

    public function delete($o) {
        $query = "DELETE FROM Action WHERE id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o)) or die("erreur delete");
    }

    public function findAll() {
        $query = "select a.*, CONCAT(u.nom, ' ', u.prenom) as us, CONCAT(c.nom, ' ', c.prenom) as cl, CONCAT (f.nom,' ', f.prenom) as fo from Action a LEFT join Client c on a.client = c.id LEFT join Fournisseur f on f.id = a.fournisseur LEFT join User u on u.id = a.enCharge";
        $req = $this->connexion->getConnexion()->query($query);
        $actions = $req->fetchAll(PDO::FETCH_OBJ);
        return $actions;
    }

    public function findById($id) {
        $query = "select * from Action where id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }
    
    public function findByIdTable($id) {
        $query = "select a.*, CONCAT(u.nom, ' ', u.prenom) as us, CONCAT(c.nom, ' ', c.prenom) as cl, CONCAT (f.nom,' ', f.prenom) as fo from Action a LEFT join Client c on a.client = c.id LEFT join Fournisseur f on f.id = a.fournisseur LEFT join User u on u.id = a.enCharge where a.id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {$fornisseur=NULL;$client=NULL;
        if($o->getFournisseur()!=="null")
            $fornisseur=$o->getFournisseur();
        if($o->getClient()!=="null")
            $client=$o->getClient();
        $query = "UPDATE Action SET date = ?, dateEchance=?,enCharge=?,commentaire=?,client=?,fournisseur=? where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getDate(), $o->getDateEchance(), $o->getEnCharge(),$o->getCommentaire(),$client,$fornisseur,$o->getId())) or die('Error');
    }
    /* Mohammed Amine AYACHE Added : */
    public function getAlert() {
        $query = "SELECT COUNT(*) as nbr FROM Action WHERE dateEchance<=date(NOW()) AND etat<>'Réglée'";
        $req = $this->connexion->getConnexion()->query($query);
        $actions = $req->fetchAll(PDO::FETCH_OBJ);
        return $actions;
    }
    public function getAlertData() {
        $query = "SELECT * FROM Action WHERE dateEchance<=date(NOW()) AND etat<>'Réglée'";
        $req = $this->connexion->getConnexion()->query($query);
        $actions = $req->fetchAll(PDO::FETCH_OBJ);
        return $actions;
    }
    public function updateEtats() {
        $query = "UPDATE Action SET etat = 'Non Réglée' WHERE etat='En attente' AND dateEchance<=date(NOW());
        UPDATE Action SET etat = 'En attente' WHERE dateEchance>date(NOW())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute() or die('Error');
    }
    public function updateEtat($id,$etat) {
        $query = "UPDATE Action SET etat =? WHERE id=?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($etat,$id)) or die('Error');
    }
    /* End Adding */

}
