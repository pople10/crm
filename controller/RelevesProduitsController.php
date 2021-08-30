<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'connexion/Connexion.php';

Class RelevesProduitsService {
    private $connexion;

    function __construct() {

        $this->connexion = new Connexion();

    }
    public function find($tableName,$id) {
        try {
            $query = 'CALL 	getRelevesProduits("'.$tableName.'","'.(int)$id.'")';
            $req = $this->connexion->getConnexion()->query($query);
            $all = $req->fetchAll(PDO::FETCH_OBJ);
            return $all;
        } catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }
        return null;
    }
}

$rs = new RelevesProduitsService();
$data = $rs->find("","");
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($tableName,$id)) {
        $data = $rs->find($tableName,$id);
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}
