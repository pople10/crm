<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/ProduitService.php';

$ps = new ProduitService();

$data = $ps->findAll();

$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);


    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            $statut = $status1_check . $status2_check . $status3_check . $status4_check;
            if (!$ps->create(new Produit($reference_input, $designationvente_input, $designationachat_input,$appellation ,$description_textarea, $customFile, $tarifht_input, $tva_select, $tarifttc_input, $enpromotion_check, $datedu_input, $dateau_input, $prixpromoht_input, $remise2_input, $remise3_input, $remise4_input, $remise5_input, $categoriec_select, $famillec_select, "", $marquec_select, $gereenstock_check, $quantite_en_stock, $stockalert_input,$quantitemax_input, $principaleu_select, $venteu_select, $longeur_input, $largeur_input, $epaisseur_input, $statut)))
                $response = false;
        }else if ($op == "update") {
            $statut = $status1_check . $status2_check . $status3_check . $status4_check;
            if (!$ps->update(new Produit($reference_input, $designationvente_input, $designationachat_input,$appellation,$description_textarea, $customFile, $tarifht_input, $tva_select, $tarifttc_input, $enpromotion_check, $datedu_input, $dateau_input, $prixpromoht_input, $remise2_input, $remise3_input, $remise4_input, $remise5_input, $categoriec_select, $famillec_select, "", $marquec_select, $gereenstock_check, $quantite_en_stock, $stockalert_input,$quantitemax_input, $principaleu_select, $venteu_select, $longeur_input, $largeur_input, $epaisseur_input, $statut)))
                $response = false;
        }else if ($op == "delete") {
            if (!$ps->delete($reference))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById($reference);
        }else if ($op == "findAllByDevis") {
            $data = $ps->findAllByDevis($devis,$query);
        }else if ($op == "findAllByCommande") {
            $data = $ps->findAllByCommande($commande,$query);
        }else if ($op == "findAllByBon") {
            $data = $ps->findAllByBon($bon,$query);
        }else if ($op == "findAllByRetour") {
            $data = $ps->findAllByRetour($retour,$query);
        }else if ($op == "findAllByFacture") {
            $data = $ps->findAllByFacture($facture,$query);
        }else if ($op == "findAllByAvoir") {
            $data = $ps->findAllByAvoir($avoir,$query);
        }else if ($op == "findAllAlertes") {
            //$data = $ps->findAllAlertes();
            
            
            // DB table to use
            $table = 'Produit';
            $where = 'quantite_en_stock <= stock_alerte';
             
            // Table's primary key
            $primaryKey = 'reference';
            $i = 0;
             
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array( 
                    'db' => 'image', 
                    'dt' => $i++
                ),
                array( 'db' => 'reference',  'dt' => $i++ ),
                array( 'db' => 'designation_vente', 'dt' => $i++ ),
                array( 'db' => 'unite_principale',   'dt' => $i++ ),
                array( 'db' => 'quantite_en_stock',   'dt' => $i++ ),
                array(
                    'db'        => 'tarif_ht',
                    'dt'        => $i++
                ),
                array(
                    'db'        => 'tarif_ttc',
                    'dt'        => $i++
                ),
                array(
                    'db'        => 'quantite_max',
                    'dt'        => $i++
                )
            );
            
            $cn = new Connexion();
             
            // SQL server connection information

            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * If you just want to use the basic configuration for DataTables with PHP
             * server-side, there is no need to edit below this line.
             */
             
            require( 'ssp.class.php' );
            echo json_encode(
                //SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
                SSP::complex( $_POST, $cn->getConnexion(), $table, $primaryKey, $columns , $where )
            );
            $response =false;

            
        }else if ($op == "findAllAlertesCount") {
            $data = count($ps->findAllAlertes());
        }else if ($op == "findAllByDevisVente") {
            $data = $ps->findAllByDevisVente($devis,$query);
        }else if ($op == "findAllByCommandeVente") {
            $data = $ps->findAllByCommandeVente($commande,$query);
        }else if ($op == "findAllByBonVente") {
            $data = $ps->findAllByBonVente($bon,$query);
        }else if ($op == "findAllByRetourVente") {
            $data = $ps->findAllByRetourVente($retour,$query);
        }else if ($op == "findAllByFactureVente") {
            $data = $ps->findAllByFactureVente($facture,$query);
        }else if ($op == "findAllByAvoirVente") {
            $data = $ps->findAllByAvoirVente($avoir,$query);
        }else if ($op == "findAllAlertesVente") {
            $data = $ps->findAllAlertesVente();
        }else if ($op == "datatable"){
            // DB table to use
            $table = 'Produit';
             
            // Table's primary key
            $primaryKey = 'reference';
            $i = 0;
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array( 'db' => 'reference',  'dt' => $i++ ),
                array( 'db' => 'image', 'dt' => $i++ ),
                array( 'db' => 'designation_vente', 'dt' => $i++ ),
                array( 'db' => 'designation_achat', 'dt' => $i++ ),
                array( 'db' => 'appellation', 'dt' => $i++ ),
                array( 'db' => 'unite_principale',   'dt' => $i++ ),
                array(
                    'db'        => 'tarif_ht',
                    'dt'        => $i++
                ),
                array(
                    'db'        => 'tarif_ttc',
                    'dt'        => $i++
                )
            );
            
            $cn = new Connexion();
             
            // SQL server connection information

            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * If you just want to use the basic configuration for DataTables with PHP
             * server-side, there is no need to edit below this line.
             */
             
            require( 'ssp.class.php' );
            echo json_encode(
                //SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
                SSP::simple( $_POST, $cn->getConnexion(), $table, $primaryKey, $columns )
            );
            $response =false;

        }
    }
}
if($response){
    header('Content-type: application/json');
    echo json_encode(array("response" => $response,"data" => $data));
   
}

}