<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {


chdir('..');

ini_set('display_errors', 1);

include_once 'service/ClientService.php';
include_once 'service/FournisseurService.php';
include_once 'service/DevisAchatService.php';
include_once 'service/DevisVenteService.php';
include_once 'service/CommandeAchatService.php';
include_once 'service/CommandeVenteService.php';
include_once 'service/BonAchatService.php';
include_once 'service/BonVenteService.php';
include_once 'service/ProduitService.php';
include_once 'service/CategorieService.php';

$cs = new ClientService();
$fs = new FournisseurService();
$das = new DevisAchatService();
$dvss = new DevisVenteService();
$cas = new CommandeAchatService();
$cvss = new CommandeVenteService();
$bas = new BonAchatService();
$bvs = new BonVenteService();
$cts = new CategorieService();
$ps = new ProduitService();


header('Content-type: application/json');
echo json_encode(array("client" => count($cs->findAll()),
    "fournisseur" => count($fs->findAll()),
    "devisChat" => count($das->findAll()),
    "devisVente" => count($dvss->findAll()),
    "cmdAchat" => count($cas->findAll()),
    "cmdVente" => count($cvss->findAll()),
    "totalVente" => $bvs->findTotalByYear()->total,
    "totalDepense" => $bas->findTotalDepenseByYear()->total,
    "findMontantClient" => $cs->findMontantClient(),
    "totalbymonth" => $bas->findTotalByMonth(),
    "totalventebymonth" => $bvs->findTotalByMonth(),
    "findPurchasedProduct" => $ps->findPurchasedProduct(),
    "findSoldProduct" => $cs->findSoldProducts(),
    "findMontantFournisseur" => $fs->findMontantFournisseur(),
    "etatCommand" =>$cas->findEtatCommand(),
    "etatCommandc" =>$cvss->findEtatCommand(),
    "findCountProductByCategory" => $cts->findCountProductByCategory()));


}
