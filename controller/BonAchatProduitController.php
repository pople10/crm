<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/BonAchatProduitService.php';

$ps = new BonAchatProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new BonAchatProduit($bon,$produit,$prix,$quantite)))
                $response = false;
        }else if ($op == "update") {
            $a = Array(new BonAchatProduit($bon,$produit,$prix,$quantite),$quantiteMax);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new BonAchatProduit($bon,$produit,"",""));
            if (!$ps->delete(new BonAchatProduit($o->bon,$o->produit,$o->prix,$o->quantite)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new BonAchatProduit($bon,$produit,"",""));
        }else if ($op == "findByBon") {
            $data = $ps->findByBon($bon);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}
