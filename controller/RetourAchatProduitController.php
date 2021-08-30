<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {


chdir('..');

ini_set('display_errors', 1);

include_once 'service/RetourAchatProduitService.php';

$ps = new RetourAchatProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new RetourAchatProduit($retour,$produit,$prix,$quantite)))
                $response = false;
        }else if ($op == "update") {
            $a = Array(new RetourAchatProduit($retour,$produit,$prix,$quantite),$quantiteMax);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "addMany") {
            $data = $ps->addMany($retour);
        }else if ($op == "delete") {
            $o = $ps->findById(new RetourAchatProduit($retour,$produit,"",""));
            if (!$ps->delete(new RetourAchatProduit($o->retour,$o->produit,$o->prix,$o->quantite)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new RetourAchatProduit($retour,$produit,"",""));
        }else if ($op == "findByRetour") {
            $data = $ps->findByRetour($retour);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));


}
