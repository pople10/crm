<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/EntrepriseService.php';

$ps = new EntrepriseService();

$data = $ps->getData();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($op) && !empty($op)) {

        if ($op == "update") {
            if (!$ps->update(new Entreprise(null, $nomFr, $nomAr, $indicationFr, $indicationAr,$codeice,$codeif, $adresse,$ville, $telephone, $fax,$remise,null)))
                $response = false;
        }else if ($op == "updateLogo"){
            if (!$ps->updateLogo($logo))
                $response = false;
        }
        else if($op == "GetMaxRemise")
        {
            $data=$ps->GetMaxRemise();
        }

    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));


}
