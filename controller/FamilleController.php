<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/FamilleService.php';
extract($_POST);

$es = new FamilleService();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op) && !empty($op)) {
        if (($op == "add") && !empty($nom)) {
            $f = $es->findById($famille);
            $ff = null;
            if ($f != null) {
                $ff = new Famille($f->id, null, null);
            }
            $es->create(new Famille(0, $nom, $ff));
            $response = true;
        } else if ($op == "delete") {
            $es->delete($id);
            $response = false;
        } else if ($op == "update") {
            header('Content-type: application/json');
            echo json_encode($es->findById($id));
            $response = false;
        } else if ($op == "newUpdate") {
            $f = $es->findById($famille);
            $ff = new Famille($f->id, null, null);
            $famille = new Famille($id, $nom, $ff);
            $es->update($famille);
            $response = true;
        } else if ($op == "datatable"){
            // DB table to use  select f.*, ff.nom as name from Famille f LEFT OUTER JOIN Famille ff on ff.id = f.famille
            $table = 'Famille';
            
            $joinQuery = "FROM `{$table}` AS `f` LEFT OUTER JOIN `{$table}` AS `ff` ON (`ff`.`id` = `f`.`famille`)";
            $extraCondition = "";

            // Table's primary key
            $primaryKey = 'id';
            $i= 0;
             
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
             $columns = array(
                array( 'db' => '`f`.`nom`', 'dt' => $i++, 'field' => 'nom'  ),
                array( 'db' => '`ff`.`nom`',  'dt' => $i++, 'field' => 'name', 'as' => 'name' ),
                array( 'db' => '`f`.`id`', 'dt' => $i++, 'field' => 'id' )
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
                SSP2::simple( $_POST, $cn->getConnexion(), $table, $primaryKey, $columns , $joinQuery, $extraCondition)
            );
            exit;

        }
    }
}

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode($es->findAll());
}


}