<?php

include_once 'beans/Famille.php';

include_once 'dao/IDao.php';

include_once 'connexion/Connexion.php';

include_once 'service/HistoriqueActionService.php';

class FamilleService implements IDao {

    private $connexion;
    private $watch;

    function __construct() {

        $this->connexion = new Connexion();
        $this->watch = new HistoriqueActionService();
    }

    public function create($o) {

        $query = "INSERT INTO Famille VALUES (NULL,?, ?)";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getNom(), $o->getFamille() == null ? null : $o->getFamille()->getId())) or die('Error');

        $this->watch->create(new HistoriqueAction(null, null, "Insertion d'une nouvelle famille", 'add', null, null, json_encode($this->getLastInserted())));
    }

    public function getLastInserted() {
        $query = "select * from Famille where id = (SELECT LAST_INSERT_ID())";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function delete($o) {

        $query = "DELETE FROM Famille WHERE id = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $old = json_encode($this->findById($o));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o)) or die("erreur delete");

        $this->watch->create(new HistoriqueAction(null, null, "Suppression d'une famille", 'delete', null, $old, null));
    }

    public function findAll() {

        $query = "select f.*, ff.nom as name from Famille f LEFT OUTER JOIN Famille ff on ff.id = f.famille";

        $req = $this->connexion->getConnexion()->query($query);

        $familles = $req->fetchAll(PDO::FETCH_OBJ);

        return $familles;
    }

    public function findById($id) {

        $query = "select f.*,ff.nom as name from Famille f LEFT OUTER JOIN Famille ff on ff.id = f.famille where f.id =?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetch(PDO::FETCH_OBJ);

        return $res;
    }

    public function getSousFamille($id) {

        $query = "SELECT * FROM Famille where famille = ?";

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($id));

        $res = $req->fetchAll(PDO::FETCH_OBJ);

        return $res;
    }

    public function update($o) {

        $query = "UPDATE Famille SET nom = ?, famille = ? where id = ?";

        $old = json_encode($this->findById($o->getId()));

        $req = $this->connexion->getConnexion()->prepare($query);

        $req->execute(array($o->getNom(), $o->getFamille()->getId(), $o->getId())) or die('Error');

        $new = json_encode($this->findById($o->getId()));

        $this->watch->create(new HistoriqueAction(null, null, "Modification d'une famille", 'update', null, $old, $new));
    }

}
