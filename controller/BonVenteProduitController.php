<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/BonVenteProduitService.php';

$ps = new BonVenteProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new BonVenteProduit($bon,$produit,$prix,$quantite,$remise)))
                $response = false;
        }else if ($op == "update") {
            $a = Array(new BonVenteProduit($bon,$produit,$prix,$quantite,$remise),$quantiteMax);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new BonVenteProduit($bon,$produit,"","",""));
            if (!$ps->delete(new BonVenteProduit($o->bon,$o->produit,$o->prix,$o->quantite,$o->remise)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new BonVenteProduit($bon,$produit,"","",""));
        }else if ($op == "findByBon") {
            $data = $ps->findByBon($bon);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));


}
