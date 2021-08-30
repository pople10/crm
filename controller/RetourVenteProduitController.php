<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/RetourVenteProduitService.php';

$ps = new RetourVenteProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new RetourVenteProduit($retour,$produit,$prix,$quantite,$remise)))
                $response = false;
        }else if ($op == "addMany") {
//            $d = json_decode($retour);
            $data = $ps->addMany($retour);
        }else if ($op == "update") {
            $a = Array(new RetourVenteProduit($retour,$produit,$prix,$quantite,$remise),$quantiteMax);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new RetourVenteProduit($retour,$produit,"","",""));
            if (!$ps->delete(new RetourVenteProduit($o->retour,$o->produit,$o->prix,$o->quantite,$o->remise)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new RetourVenteProduit($retour,$produit,"","",""));
        }else if ($op == "findByRetour") {
            $data = $ps->findByRetour($retour);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));


}
