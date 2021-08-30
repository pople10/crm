<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/AvoirVenteProduitService.php';

$ps = new AvoirVenteProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new AvoirVenteProduit($avoir,$produit,$prix,$quantite)))
                $response = false;
        }else if ($op == "update") {
            $a = Array(new AvoirVenteProduit($avoir,$produit,$prix,$quantite),$quantiteMax);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new AvoirVenteProduit($avoir,$produit,"",""));
            if (!$ps->delete(new AvoirVenteProduit($o->avoir,$o->produit,$o->prix,$o->quantite)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new AvoirVenteProduit($avoir,$produit,"",""));
        }else if ($op == "findByAvoir") {
            $data = $ps->findByAvoir($avoir);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}
