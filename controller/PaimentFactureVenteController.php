<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/PaimentFactureVenteService.php';

$ps = new PaimentFactureVenteService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new PaimentFactureVente(NULL,$facture,$date,$type,$numero_cheque,$montant)))
                $response = false;
        }if ($op == "multipleAdd") {

            foreach ($items as $v) {
                if (!$ps->create(new PaimentFactureVente(NULL,$v["id"],date("Y-m-d"),$type,$numero_cheque,$v["montant"])));
                    $response = false;
            }
        }else if ($op == "update") {
            if (!$ps->update(new PaimentFactureVente($id,$facture,$date,$type,$numero_cheque,$montant)))
                $response = false;
        }else if ($op == "delete") {
            if (!$ps->delete($id))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById($id);
        }else if ($op == "findAllByFacture") {
            $data = $ps->findAllByFacture($id);
        }else if($op == "findMontantById"){
            $data = $ps->findMontantById($id);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}