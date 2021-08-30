<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/FactureVenteProduitService.php';

$ps = new FactureVenteProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new FactureVenteProduit($facture,$produit,$prix,$quantite,$remise)))
                $response = false;
        }else if ($op == "update") {
            $a = Array(new FactureVenteProduit($facture,$produit,$prix,$quantite,$remise),$quantiteMax);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new FactureVenteProduit($facture,$produit,"","",""));
            if (!$ps->delete(new FactureVenteProduit($o->facture,$o->produit,$o->prix,$o->quantite,"")))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new FactureVenteProduit($facture,$produit,"",""));
        }else if ($op == "findByFacture") {
            $data = $ps->findByFacture($facture);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}
