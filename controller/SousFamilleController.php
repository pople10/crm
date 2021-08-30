<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/FamilleService.php';

extract($_POST);

$cs = new FamilleService();

$data = array();

if (isset($id) && !empty($id)) {

    $f = $cs->getSousFamille($id);
    $data = array("data"=>$cs->getSousFamille($id));
}

header('Content-type: application/json');

echo json_encode($data);


}


