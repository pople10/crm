<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/FactureVenteService.php';
include_once 'service/PaimentFactureVenteService.php';
include_once 'service/ClientService.php';
$array = array();
$fv = new FactureVenteService();
$pfv = new PaimentFactureVenteService();
$cl = new ClientService();
$i=0;
foreach($cl->getAlertedClients() as $val)
{   
    $nom="";
    $prenom="";
    $array[$i]["etat"]=$val->etat;
    if($val->nom!=NULL)
        $nom = $val->nom;
    if($val->prenom!=NULL)
        $prenom = $val->prenom;
    $array[$i]["client"]=$nom." ".$prenom;
    $array[$i]["clientID"]=$val->id;
    $array[$i]["genre"]="Plafond est dépassé ( ".$val->plafond." )";
    $array[$i]["date"]=NULL;
    $array[$i]["bon"]=NULL;
    $array[$i]["total_ht"]=NULL;
    $array[$i]["tva"]=NULL;
    $array[$i]["paid"]=NULL;
    $array[$i]["unpaid"]=NULL;
    $array[$i]["id"]=NULL;
    $array[$i]["duration"]=NULL;
    $i++;
}
foreach($fv->LatePayments() as $val){
    $array[$i]["id"]=$val->id;
    $client = $cl->findById($val->client);
    $nom="";
    $prenom="";
    $array[$i]["etat"]=$client->etat;
    $array[$i]["clientID"]=$val->client;
    if($client->nom!=NULL)
        $nom = $client->nom;
    if($client->prenom!=NULL)
        $prenom = $client->prenom;
    $array[$i]["client"]=$nom." ".$prenom;
    $array[$i]["date"]=$val->date;
    $thatday = date_create($val->date);
    $today=date_create(date("Y-m-d"));
    $diff=date_diff($today,$thatday);
    $array[$i]["duration"]=$diff->format("%a");
    $array[$i]["bon"]=$val->bon;
    $array[$i]["total_ht"]=$val->total_ht;
    $array[$i]["tva"]=$val->tva;
    $array[$i]["genre"]="Retard de paiment";
    $paid = $pfv->findMontantById($val->id)[0]->total;
    if((intval($array[$i]["total_ht"])+intval($array[$i]["tva"]))!=0){
    if($paid!=NULL)
    {
        $paid=floatval($paid);
        if($paid<(intval($array[$i]["total_ht"])+intval($array[$i]["tva"])))
        {
            $array[$i]["paid"]=$paid;
            $array[$i]["unpaid"]=(intval($array[$i]["total_ht"])+intval($array[$i]["tva"]))-$paid;
        }
        else {unset($array[$i]);$i--;}
    }
    else
    {       $paid=0;
            $array[$i]["paid"]=$paid;
            $array[$i]["unpaid"]=(intval($array[$i]["total_ht"])+intval($array[$i]["tva"]))-$paid;
    }
    }
    else {unset($array[$i]);$i--;}
    $i++;
}

//echo $i;
//var_dump($array);
$array1["data"]=array_values($array);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);
    if(isset($op)&&!empty($op)){
    if($op=="Count")
    {
        $array1["data"]=$i;
    }}

}

header('Content-type: application/json');
echo json_encode($array1);


}
