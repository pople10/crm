<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {


chdir('..');

ini_set('display_errors', 1);

include_once 'service/DevisVenteProduitService.php';

$ps = new DevisVenteProduitService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new DevisVenteProduit($devis,$produit,$prix,$quantite,$remise)))
                $response = false;
        }else if ($op == "update") {
            $a = new DevisVenteProduit($devis,$produit,$prix,$quantite,$remise);
            if (!$ps->update($a))
                $response = false;
        }else if ($op == "delete") {
            $o = $ps->findById(new DevisVenteProduit($devis,$produit,"","",""));
            if (!$ps->delete(new DevisVenteProduit($o->devis,$o->produit,$o->prix,$o->quantite,$o->remise)))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById(new DevisVenteProduit($devis,$produit,"","",""));
        }else if ($op == "findByDevis") {
            $data = $ps->findByDevis($devis);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));


}
