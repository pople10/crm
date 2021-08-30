<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {


chdir('..');
ini_set('display_errors', 1);
include_once 'service/UserRoleService.php';
extract($_POST);
$es = new UserRoleService();

$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op) && !empty($op)) {
        if (($op == "add")) {
            $es->create(new UserRole($user,$role));
            $response = true;
        } else if ($op == "delete") {
            $es->delete(new UserRole($user,$role));
            $response = false;
        }
    }
}

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode(array("response" => $response, "data" => $es->findAll()));
}

}
