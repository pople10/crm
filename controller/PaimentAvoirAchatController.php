<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {


chdir('..');

ini_set('display_errors', 1);

include_once 'service/PaimentAvoirAchatService.php';

$ps = new PaimentAvoirAchatService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new PaimentAvoirAchat(NULL, $avoir, $date, $type, $numero_cheque, $montant)))
                $response = false;
        }if ($op == "multipleAdd") {

            foreach ($items as $v) {
                if (!$ps->create(new PaimentAvoirAchat(NULL,$v["id"],date("Y-m-d"),$type,$numero_cheque,$v["montant"])));
                $response = false;
            }
        } else if ($op == "update") {
            if (!$ps->update(new PaimentAvoirAchat($id, $avoir, $date, $type, $numero_cheque, $montant)))
                $response = false;
        } else if ($op == "delete") {
            if (!$ps->delete($id))
                $response = false;
        } else if ($op == "findById") {
            $data = $ps->findById($id);
        } else if ($op == "findAllByAvoir") {
            $data = $ps->findAllByAvoir($id);
        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}