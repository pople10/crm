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

include_once 'service/RetourVenteProduitService.php';

include_once 'service/RetourAchatProduitService.php';



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

$rvps = new RetourVenteProduitService();

$raps = new RetourAchatProduitService();




header('Content-type: application/json');

echo json_encode(array("client" => count($cs->findAll()),

    "fournisseur" => count($fs->findAll()),

    "devisChat" => count($das->findAll()),

    "devisVente" => count($dvss->findAll()),

    "cmdAchat" => count($cas->findAll()),

    "cmdVente" => count($cvss->findAll()),

	"totalVente" => $bvs->findTotalByYear1()->total,
	
	"totalVenteByYear" => $bvs->findTotalByYears(),
	
	"findTotalAchatByYears" => $bas->findTotalAchatByYears(),
	
    "totalDepense" => $bas->findTotalDepenseByYear1()->total,

    "findMontantClient" => $cs->findMontantClientAndID(),

    "totalbymonth" => $bas->findTotalByMonth1(),
	
	"findNonFacture" => $bvs->findNonFacture(),

    "totalventebymonth" => $bvs->findTotalByMonth1(),

    "findPurchasedProduct" => $ps->findPurchasedProduct(),

    "findSoldProduct" => $cs->findSoldProducts(),

    "findMontantFournisseur" => $fs->findMontantFournisseur(),

    "etatCommand" =>$cas->findEtatCommand(),

    "etatCommandc" =>$cvss->findEtatCommand(),
	
	"findTop10SoldProducts" => $ps->findTop10SoldProducts(),
	
	"CountUndeliveredOrders" => $bvs->CountUndeliveredOrders(),
	
	"CountDeliveredOrders" => $bvs->CountDeliveredOrders(),
	
	"CountDeliveredPurchases" => $bas->CountDeliveredPurchases(),
	
	"CountUndeliveredPurchases" => $bas->CountUndeliveredPurchases(),
	
	"CountFundsUndeliveredPurchases" => $bas->CountFundsUndeliveredPurchases(),
	
	"UninvoicedPurchasesCount" => $bas->UninvoicedPurchasesCount(),
	
	"getReturnedProductsOrders" => $rvps->getReturnedProductsOrders(),
	
	"getReturnedProductsPurchases" => $raps->getReturnedProductsPurchases(),
	
	"ProductsSoldFundsByMonthThisYear" => $bvs->ProductsSoldFundsByMonth(date("Y")),
	
	"ProductsSoldFundsByMonthLastYear" => $bvs->ProductsSoldFundsByMonth(date("Y",strtotime("-1 year"))),
	
	"FactureImpayéVente" => $bvs->FactureImpayé(),
	
	"FacturePayéVente" => $bvs->FacturePayé(),
	
	"FactureImpayéAchat" => $bas->FactureImpayé(),
	
	"getAllProductsNameAndCodes"=>$bvs->getAllProductsNameAndCodes(),

    "findCountProductByCategory" => $cts->findCountProductByCategory()));

}






