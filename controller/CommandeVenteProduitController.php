<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/CommandeVenteProduitService.php';

$ps = new CommandeVenteProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new CommandeVenteProduit($commande,$produit,$prix,$quantite,$remise)))
                $response = false;
        }else if ($op == "update") {
            $a = new CommandeVenteProduit($commande,$produit,$prix,$quantite,$remise);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new CommandeVenteProduit($commande,$produit,"","",""));
            if (!$ps->delete(new CommandeVenteProduit($o->commande,$o->produit,$o->prix,$o->quantite,$o->remise)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new CommandeVenteProduit($commande,$produit,"","",""));
        }else if ($op == "findByCommande") {
            $data = $ps->findByCommande($commande);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}
