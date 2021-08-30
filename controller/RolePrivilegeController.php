<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/RolePrivilegeService.php';
extract($_POST);
$es = new RolePrivilegeService();

$response = true;
$data = $es->findAll();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op) && !empty($op)) {
        if (($op == "add")) {
            if(!$es->create(new RolePrivilege($role,$privilege)))

            $response = true;
        } else if ($op == "delete") {
            if(!$es->delete(new RolePrivilege($role,$privilege)))
                $data = false;
            $response = true;
        }else if ($op == "findAllRolePrivilege") {
            header('Content-type: application/json');
            echo json_encode($es->findAllRolePrivilege());
            $response = false;
        }
    }
}

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode(array("response" => $response, "data" => $data));
}


}