<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/CategorieService.php';
extract($_POST);
$es = new CategorieService();

$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op) && !empty($op)) {
        if (($op == "add") && !empty($code)) {
            $es->create(new Categorie(0, $code, $libelle));
            $response = true;
        } else if ($op == "delete") {
            $es->delete($id);
            $response = false;
        } else if ($op == "update") {
            header('Content-type: application/json');
            echo json_encode($es->findById($id));
            $response = false;
        } else if ($op == "newUpdate") {
            $categorie = new Categorie($id, $code, $libelle);
            $es->update($categorie);
            $response = true;
        } else if ($op == "datatable"){
            // DB table to use  select f.*, ff.nom as name from Famille f LEFT OUTER JOIN Famille ff on ff.id = f.famille
            $table = 'Categorie';
            
            // Table's primary key
            $primaryKey = 'id';
            $i= 0;
             
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
             $columns = array(
                array( 'db' => 'id', 'dt' => $i++),
                array( 'db' => 'code',  'dt' => $i++),
                array( 'db' => 'libelle', 'dt' => $i++),
                array( 'db' => 'id', 'dt' => $i++)
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
                SSP::simple( $_POST, $cn->getConnexion(), $table, $primaryKey, $columns)
            );
            exit;

        }
    }
}

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode(array("response" => $response, "data" => $es->findAll()));
}

}
