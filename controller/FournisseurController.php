<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/FournisseurService.php';
extract($_POST);
$cs = new FournisseurService();
$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op) && !empty($op)) {
        if ($op == "add") {
            if ($type == "Particulier") {
                $cs->create(new Fournisseur(0, $nom, $prenom, $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $note, $text1, $text2, $text3, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable, $charge));
            } else if ($type == "Société") {
                $cs->create(new Fournisseur(0, $noms, '', $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $note, $text1, $text2, $text3, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable, $charge));
            }
            $response = true;
        } else if ($op == "delete") {
            $cs->delete($id);
            $response = false;
        } else if ($op == "update") {
            header('Content-type: application/json');
            echo json_encode($cs->findById($id));
            $response = false;
        } else if ($op == "newUpdate") {
            if ($type == "Particulier") {
                $client = new Fournisseur($id, $nom, $prenom, $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $note, $text1, $text2, $text3, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable,  $charge);
            } else if ($type == "Société") {
                $client = new Fournisseur($id, $noms, '', $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $note, $text1, $text2, $text3, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable, $charge);
            }
            $cs->update($client);
            $response = true;
        }else if ($op == "datatable"){
            // DB table to use
            $table = "Fournisseur";
             
            // Table's primary key
            $primaryKey = 'id';
            $i= 0;
             
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array( 'db' => 'id', 'field' => 'id', 'dt' => $i++ ),
                array( 'db' => 'nom', 'field' => 'nom',   'dt' => $i++ ),
                array( 'db' => 'email', 'field' => 'email',   'dt' => $i++ ),
                array( 'db' => 'telephone', 'field' => 'telephone',   'dt' => $i++ ),
                array( 'db' => 'fax',  'field' => 'fax',   'dt' => $i++ )
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

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode(array("response" => $response, "data" => $cs->findAll()));
}


}
