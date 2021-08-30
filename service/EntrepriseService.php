<?php

include_once 'beans/Entreprise.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
include_once 'service/HistoriqueActionService.php';

class EntrepriseService implements IDao
{

    private $connexion;
    private $watch;

    function __construct() {
        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
        $this->create(0);
    }

    public function create($o)
    {
        $query = 'INSERT IGNORE INTO Entreprise set id = 0, nom_fr ="",nom_ar="", indication_fr ="",indication_ar="",code_ice="",code_if="",adresse="",telephone="",fax="",remise="",logo="no-photo.png",ville=""';
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute() or die('Error');
    }

    public function update($o)
    {
        $r = true;
        $old = json_encode($this->getData());
        $query = "UPDATE `Entreprise` SET nom_fr=?,nom_ar=?,indication_fr=?,indication_ar=?,code_ice=?,code_if=?,adresse=?,ville=?,telephone=?,fax=?,remise=? WHERE id= 0";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNomFr(),$o->getNomAr(),$o->getIndicationFr(),$o->getIndicationAr(),$o->getCodeIce(),$o->getCodeIf(),$o->getAdresse(),$o->getVille(),$o->getTelephone(),$o->getFax(),$o->getRemise())) or $r = false;

        if($r){
            $new = json_encode($this->getData());
            $this->watch->create(new HistoriqueAction(null,null,'Modification dans la page entreprise','update',null,$old,$new));
        }
        return $r;
    }
    public function updateLogo($logo)
    {
        $r = true;
        $query = "UPDATE `Entreprise` SET logo=? WHERE id= 0";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($logo)) or $r = false;
        return $r;

    }
    public function delete($obj)
    {
        // TODO: Implement delete() method.
    }

    public function getData()
    {
        $query = "select * from Entreprise where id = 0";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }
    public function GetMaxRemise()
    {
        $query = "select remise from Entreprise where id = 0";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }
}