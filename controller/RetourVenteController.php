<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'service/RetourVenteService.php';

$ps = new RetourVenteService();

$data = $ps->findAll();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);


    if (isset($op) && !empty($op)) {

        if ($op == "add") {
            if (!$ps->create(new RetourVente(NULL,$client,$date_creation,"",$etat)))
                $response = false;
        }else if ($op == "update") {
            if (!$ps->update(new RetourVente($id,$client,$date_creation,"",$etat)))
                $response = false;
        }else if ($op == "updateEtat") {
            if (!$ps->updateEtat(new RetourVente($id,"","",date("Y-m-d"),$etat)))
                $response = false;
        }else if ($op == "delete") {
            if (!$ps->delete($id))
                $response = false;
        }else if ($op == "findById") {
            $data = $ps->findById($id);
        }else if ($op == "getLastPrice") {
            $data = $ps->getLastPrice($produit);
        }else if ($op == "lastID") {
            $data = $ps->LastID();
        }else if ($op == "datatable"){
            // DB table to use
            $table = "RetourVenteView";
             
            // Table's primary key
            $primaryKey = 'id';
            $i= 0;
             
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array( 'db' => 'etat', 'dt' => $i++ ),
                array( 'db' => 'id', 'dt' => $i++ ),
                array( 'db' => 'date_creation',   'dt' => $i++ ),
                array( 'db' => 'nom',   'dt' => $i++ ),
                array( 'db' => 'total_ht', 'dt' => $i++ ),
                array( 'db' => 'tva', 'dt' => $i++ ),
                array( 'db' => 'total_ttc', 'dt' => $i++ ),
                array( 'db' => 'client', 'dt' => $i++ ),
                array( 'db' => 'nomF', 'dt' => $i++ ),
                array( 'db' => 'adresseF', 'dt' => $i++ ),
                array( 'db' => 'villeF', 'dt' => $i++ ),
                array( 'db' => 'paysF', 'dt' => $i++ ),
                array( 'db' => 'teleF', 'dt' => $i++ ),
                array( 'db' => 'faxF', 'dt' => $i++ ),
                array( 'db' => 'nomE', 'dt' => $i++ ),
                array( 'db' => 'adresseE', 'dt' => $i++ ),
                array( 'db' => 'villeE', 'dt' => $i++ ),
                array( 'db' => 'teleE', 'dt' => $i++ ),
                array( 'db' => 'faxE', 'dt' => $i++ ),
                array( 'db' => 'image', 'dt' => $i++ ),
                array( 'db' => 'codeICE', 'dt' => $i++ ),
                array( 'db' => 'bon', 'dt' => $i++ )
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
            exit;

        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data));

}