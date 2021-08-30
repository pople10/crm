<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/ActionService.php';
include_once 'service/ClientService.php';
include_once 'service/FournisseurService.php';
include_once 'service/UserService.php';
extract($_POST);
$as = new ActionService();
$cs = new ClientService();
$fs = new FournisseurService();
$cms = new UserService();

$response = true;

//Update des états
$as->updateEtats();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op) && !empty($op)) {
        if ($op == "add") {
            $as->create(new Action(0, $date, $dateEchance, $enCharge, $commentaire, $client, $fournisseur,"En attente"));
            $response = true;
        } else if ($op == "delete") {
            $as->delete($id);
            $response = false;
        } else if ($op == "update") {
            header('Content-type: application/json');
           //echo json_encode($es->findById($id));4
           $as->update(new Action($id, $date, $dateEchance, $enCharge, $commentaire, $client, $fournisseur,""));
            $response = true;
        } 
        else if ($op == "getAlert"){
            header('Content-type: application/json');
           echo json_encode($as->getAlert());
            $response = false;
        }
        else if ($op == "getAlertData"){
            header('Content-type: application/json');
           echo json_encode($as->getAlertData());
            $response = false;
        }
        else if ($op == "findByIdTable"){
            header('Content-type: application/json');
           echo json_encode($as->findByIdTable($id));
            $response = false;
        }
        else if ($op == "findById"){
            header('Content-type: application/json');
           echo json_encode($as->findById($id));
            $response = false;
        }
        else if ($op == "updateEtat"){
            $as->updateEtat($id,$etat);
        }
        else if ($op == "newUpdate") {
            //$categorie = new Categorie($id, $code, $libelle);
            //$es->update($categorie);
            $response = true;
        }
    }
}

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode(array("response" => $response, "data" => $as->findAll(),
        "fList" => $fs->findAll(), "cList" => $cs->findAll(), "mList"=> $cms->findAll()));
}

}