<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/HistoriqueActionService.php';
extract($_POST);
$es = new HistoriqueActionService();

$response = true;

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    if (isset($op) && !empty($op)) {
//        if (($op == "add") && !empty($nom)) {
//            $es->create(new HistoriqueAction(0, $nom));
//            $response = true;
//        } else if ($op == "delete") {
//            $es->delete($id);
//            $response = false;
//        } else if ($op == "update") {
//            header('Content-type: application/json');
//            echo json_encode($es->findById($id));
//            $response = false;
//        } else if ($op == "newUpdate") {
//            $action = new HistoriqueAction($id, $nom);
//            $es->update($action);
//            $response = true;
//        }
//    }
//}

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode(array("response" => $response, "data" => $es->findAll()));
}

}
