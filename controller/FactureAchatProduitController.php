<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/FactureAchatProduitService.php';

$ps = new FactureAchatProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new FactureAchatProduit($facture,$produit,$prix,$quantite)))
                $response = false;
        }else if ($op == "update") {
            $a = new FactureAchatProduit($facture,$produit,$prix,$quantite);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new FactureAchatProduit($facture,$produit,"",""));
            if (!$ps->delete(new FactureAchatProduit($o->facture,$o->produit,$o->prix,$o->quantite)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new FactureAchatProduit($facture,$produit,"",""));
        }else if ($op == "findByFacture") {
            $data = $ps->findByFacture($facture);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}
