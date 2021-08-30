<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/RoleService.php';
extract($_POST);
$es = new RoleService();

$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op) && !empty($op)) {
        if (($op == "add") && !empty($nom)) {
            $es->create(new Role(0, $nom));
            $response = true;
        } else if ($op == "delete") {
            $es->delete($id);
            $response = false;
        } else if ($op == "update") {
            header('Content-type: application/json');
            echo json_encode($es->findById($id));
            $response = false;
        } else if ($op == "newUpdate") {
            $role = new Role($id, $nom);
            $es->update($role);
            $response = true;
        } else if ($op == "findByUserHavent") {
            header('Content-type: application/json');
            echo json_encode($es->findByUserHavent($id));
            $response = false;
        }else if ($op == "findByUserHave") {
            header('Content-type: application/json');
            echo json_encode($es->findByUserHave($id));
            $response = false;
        }
    }
}

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode(array("response" => $response, "data" => $es->findAll()));
}

}
