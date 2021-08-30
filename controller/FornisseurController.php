<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {


chdir('..');
ini_set('display_errors', 1);
include_once 'service/FournisseurService.php';
extract($_POST);
$response=true;
$cs = new FournisseurService();
if (!empty($op)) {
    if($op=="findById"){
        if(isset($id) and !empty($id)){$response=false;
        header('Content-type: application/json');
        echo json_encode($cs->findById($id));
        
        }
    }
}
if (!empty($nom)) {
    if (empty($prenom)) {
        $type = "Entreprise";
    } else {
        $type = "Particulier";
    }
    $cs->create(new Fournisseur(0, $nom, $prenom, $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement));
}
if($response==true){
header('Content-type: application/json');
echo json_encode(array("data" => $cs->findAll()));}


}
