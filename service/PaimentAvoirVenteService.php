<?php

include_once 'beans/PaimentAvoirVente.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';


class PaimentAvoirVenteService Implements IDao {

    private $connexion;
    private $watch;


    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
        
    }

    public function create($o) {

        $query = "INSERT INTO PaimentAvoirVente VALUES (NULL,?,?,?,?,?)";

        $req = $this->connexion->getConnexion()->prepare($query);
        
        $req->execute(array($o->getAvoir(), $o->getDate(), $o->getType(),$o->getNumeroCheque(),$o->getMontant())) or die('Error');
                
        $new = json_encode($this->getLastInserted());
        
        $this->watch->create(new HistoriqueAction(null,null,"Insertion d'un nouveau paiment d'avoir de vente",'add',null,null,$new));
    }

    public function getLastInserted() {
        
        $query = "select * from PaimentAvoirVente where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }


    public function delete($id) {

        $query = "DELETE FROM PaimentAvoirVente WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($id));

        $req->execute(array($id)) or die("erreur delete");
        
        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'un paiment d'avoir de vente", 'delete', null, $old, null));


    }

    public function findAll() {

        $query = "SELECT PFA.*,FA.client,FA.date as dateA,FA.type as typeA,FA.bon as bonA FROM PaimentAvoirVente PFA inner join AvoirVente FA on FA.id = PFA.avoir";

        $req = $this->connexion->getConnexion()->query($query);

        $all = $req->fetchAll(PDO::FETCH_OBJ);

        return $all;

    }

    public function findById($id) {

        $query = "SELECT PFA.*,FA.client,FA.date as dateA,FA.type as typeA,FA.bon as bonA FROM PaimentAvoirVente PFA inner join AvoirVente FA on FA.id = PFA.avoir where PFA.id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function findAllByAvoir($id) {

        $query = "SELECT PFA.*,FA.client,FA.date as dateA,FA.type as typeA,FA.bon as bonA FROM PaimentAvoirVente PFA inner join AvoirVente FA on FA.id = PFA.avoir where PFA.avoir =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE PaimentAvoirVente SET avoir=?,date=?,type=?,numero_cheque=?,montant=? where id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o->getId()));

        $req->execute(array($o->getAvoir(), $o->getDate(), $o->getType(),$o->getNumeroCheque(),$o->getMontant(), $o->getId())) or die('Error');
        
        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null,null,"Modification d'un paiment d'avoir de vente",'update',null,$old,$new));
    }

}
