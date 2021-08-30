<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');

ini_set('display_errors', 1);

include_once 'connexion/Connexion.php';
include_once 'service/EntrepriseService.php';

Class RelevesService {
    private $connexion;

    function __construct() {

        $this->connexion = new Connexion();

    }
    public function find($dateD,$dateF,$f,$et,$tableName) {
        try {
            $query = 'CALL 	getRelevesFournisseurs("'.$dateD.'","'.$dateF.'",'.(int)$f.',"'.$et.'","'.$tableName.'")';
            $req = $this->connexion->getConnexion()->query($query);
            $all = $req->fetchAll(PDO::FETCH_OBJ);
            return $all;
        } catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }
        return null;
    }
}

$rs = new RelevesService();
$es = new EntrepriseService();
$data = $rs->find("","","","","");
$entreprise = $es->getData();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    if (isset($dateD,$dateF,$f,$et,$tableName)) {
        $data = $rs->find($dateD,$dateF,$f,$et,$tableName);
        
        if ($op == "datatable"){
            // DB table to use  select f.*, ff.nom as name from Famille f LEFT OUTER JOIN Famille ff on ff.id = f.famille
            
            /* 
            select * from RelevesView R where 
            */
            $table = 'RelevesView';
            
            $joinQuery = "";
            $c1 = ($dateD != '' && $dateF != '') ? "date BETWEEN \"{$dateD}\" and \"{$dateF}\" " : "1=1";
            $c2 = ($f != '') ? " and idF ={$f} " : " and 1=1";
            $c3 = ($et != '' && $tableName != '') ? " and etat like \"{$et}\" and tablename = \"{$tableName}\" " : " and 1=1";
            $extraCondition = $c1.$c2.$c3; 

            // Table's primary key
            $primaryKey = '_id';
            $i= 0;
             
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
             $columns = array(
                array( 'db' => '_id', 'dt' => $i++, 'field' => '_id'  ),
                array( 'db' => 'etat', 'dt' => $i++, 'field' => 'etat'  ),
                array( 'db' => 'date', 'dt' => $i++, 'field' => 'date'  ),
                array( 'db' => 'nom',  'dt' => $i++, 'field' => 'nom'),
                array( 'db' => 'total_ht',  'dt' => $i++, 'field' => 'total_ht'),
                array( 'db' => 'total_ttc',  'dt' => $i++, 'field' => 'total_ttc'),
                array( 'db' => 'tablename', 'dt' => $i++, 'field' => 'tablename' ),
                array( 'db' => 'id', 'dt' => $i++, 'field' => 'id' )
            );
            
            $cn = new Connexion();
             
            // SQL server connection information

            /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * If you just want to use the basic configuration for DataTables with PHP
             * server-side, there is no need to edit below this line.
             */
             
            require( 'ssp.class.php' );
            $data = SSP2::simple( $_POST, $cn->getConnexion(), $table, $primaryKey, $columns , $joinQuery, $extraCondition);
            $data["entreprise"] = $entreprise;
            echo json_encode(
                $data
            );
            exit;

        }
    }
}

header('Content-type: application/json');
echo json_encode(array("response" => $response, "data" => $data,"entreprise" => $entreprise));

}
