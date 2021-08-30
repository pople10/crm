<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {


chdir('..');

ini_set('display_errors', 1);

include_once 'service/CommandeAchatProduitService.php';

$ps = new CommandeAchatProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new CommandeAchatProduit($commande,$produit,$prix,$quantite)))
                $response = false;
        }else if ($op == "update") {
            $a = new CommandeAchatProduit($commande,$produit,$prix,$quantite);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new CommandeAchatProduit($commande,$produit,"",""));
            if (!$ps->delete(new CommandeAchatProduit($o->commande,$o->produit,$o->prix,$o->quantite)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new CommandeAchatProduit($commande,$produit,"",""));
        }else if ($op == "findByCommande") {
            $data = $ps->findByCommande($commande);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));


}
