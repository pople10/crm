<?php


/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/ClientService.php';
include_once 'service/EntrepriseService.php';
extract($_POST);
$es = new EntrepriseService();
$cs = new ClientService();
$response = true;
$entreprise = $es->getData();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op) && !empty($op)) {
        if ($op == "add") {
            if($dateLimit=="NULL" or $dateLimit=="null")
                $dateLimit=NULL;
            if ($type == "Particulier") {
                $response = $cs->create(new Client(0, $nom, $prenom, $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $mode, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable, $plafond, $plafondEmpye, $douteux,$dateLimit));
            } else if ($type == "Société") {
                $cs->create(new Client(0, $noms, '', $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $mode, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable, $plafond, $plafondEmpye, $douteux,$dateLimit));
            }
            $response = true;
        } else if ($op == "delete") {
            $cs->delete($id);
            $response = false;
        } else if ($op == "update") {
            header('Content-type: application/json');
            echo json_encode($cs->findById($id));
            $response = false;
        } else if ($op == "comptes") {

            if ( isset($opp) && $opp == "datatable"){
                // DB table to use
    
                $table = 'comptesClient';
                
                $joinQuery = "FROM `{$table}` AS `cc` CROSS JOIN (SELECT @s := 0.0,@c := 0.0,@d := 0.0,@tc := 0.0,@td := 0.0) AS nothing ";
                $c1 = ($dateD != '' && $dateF != '') ? "cc.date BETWEEN \"{$dateD}\" and \"{$dateF}\" " : "1=1";
                $c2 = " and cc.client = {$client} and cc.total_ttc is not null";
                $extraCondition = $c1.$c2; 
    
                // Table's primary key
                $primaryKey = 'id';
                $i= 0;
                 
                // Array of database columns which should be read and sent back to DataTables.
                // The `db` parameter represents the column name in the database, while the `dt`
                // parameter represents the DataTables column identifier. In this case simple
                // indexes
                
                $columns = array(
                    array( 'db' => 'date', 'dt' => $i++, 'field' => 'date'  ),
                    array( 'db' => 'detail',  'dt' => $i++, 'field' => 'detail'),
                    array( 'db' => 'total_ttc',  'dt' => $i++, 'field' => 'total_ttc'),
                    array( 'db' => 'client',  'dt' => $i++, 'field' => 'client'),
                    array( 'db' => 'tablename', 'dt' => $i++, 'field' => 'tablename' ),
                    array( 'db' => 'id', 'dt' => $i++, 'field' => 'id' ),
                    array( 'db' => '@d := IF( ( cc.tablename LIKE "livraison" ) OR ( cc.tablename  LIKE "reglement.avoir.%" ), total_ttc, 0 )', 'dt' => $i++, 'field' => 'debit' , 'as' => 'debit' ),
                    array( 'db' => '@c := IF( ( cc.tablename LIKE "retour" ) OR( `cc`.`tablename` LIKE "reglement.facture.%" ), total_ttc, 0 )', 'dt' => $i++, 'field' => 'credit' , 'as' => 'credit' ),
                    array( 'db' => '@s := @s + @c - @d', 'dt' => $i++, 'field' => 'solde' , 'as' => 'solde' ),
                    array( 'db' => '(select debit from BilanClientView where code=cc.client)', 'dt' => $i++, 'field' => 'total_debit' , 'as' => 'total_debit' ),
                    array( 'db' => '(select credit from BilanClientView where code=cc.client)', 'dt' => $i++, 'field' => 'total_credit' , 'as' => 'total_credit' ),
                    array( 'db' => '(select solde from BilanClientView where code=cc.client)', 'dt' => $i++, 'field' => 'total_solde' , 'as' => 'total_solde' )

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

            header('Content-type: application/json');
            echo json_encode(Array("data"=> $cs->getComptes($dateD,$dateF,$client)));
            $response = false;
        
        } else if ($op == "bilan") {

            if ( isset($opp) && $opp == "datatable"){
                // DB table to use

                /* 
                select * from RelevesView R where 
                */
                $table = 'BilanClientView';
                
                $joinQuery = "";
                $extraCondition = ($client != '') ? " code = {$client} " : " 1=1 "; 
    
                // Table's primary key
                $primaryKey = 'code';
                $i= 0;
                 
                // Array of database columns which should be read and sent back to DataTables.
                // The `db` parameter represents the column name in the database, while the `dt`
                // parameter represents the DataTables column identifier. In this case simple
                // indexes
                 $columns = array(
                    array( 'db' => 'code', 'dt' => $i++ ),
                    array( 'db' => 'debit', 'dt' => $i++),
                    array( 'db' => 'credit', 'dt' => $i++ ),
                    array( 'db' => 'date', 'dt' => $i++ ),
                    array( 'db' => 'nom',  'dt' => $i++),
                    array( 'db' => 'solde',  'dt' => $i++)
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
            
            
            header('Content-type: application/json');
            echo json_encode(Array("data"=> $cs->getAllClientsCompte($client),"entreprise" => $entreprise));
            $response = false;
        } else if ($op == "newUpdate") {
            if($dateLimit == "NULL" or $dateLimit == "null")
                $dateLimit=NULL;
            if ($type == "Particulier") {
                $client = new Client($id, $nom, $prenom, $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $mode, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable, $plafond, $plafondEmpye, $douteux,$dateLimit);
            } else if ($type == "Société") {
                $client = new Client($id, $noms, '', $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $mode, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable, $plafond, $plafondEmpye, $douteux,$dateLimit);
            }
            $cs->update($client);
            $response = true;
        }
        else if($op == "UpdateMode")
        {
            $cs->updateMode($client,$mode);
            $response = true;
        }
        else if($op == "BlackListByLimitDate")
        {
            $cs->BlackListByLimitDate();
            $response = true;
        }
        else if($op == "UpdateEtat")
        {
            $cs->UpdateEtat($id,$etat,$dateLimit);
            header('Content-type: application/json');
            echo json_encode($cs->findById($id));
            $response = false;
        }
        else if($op == "getBlackListed")
        {
            header('Content-type: application/json');
            echo json_encode(array("data"=>$cs->getBlackListed()));
            $response = false;
        }
        else if($op == "findById")
        {
            header('Content-type: application/json');
            echo json_encode($cs->findById($id));
            $response = false;
        }
        else if($op == "updateAllRemises")
        {
            $cs->updateAllRemises($max);
            $response = true;
        }
        else if ($op == "datatable"){
            // DB table to use
            $table = "Client";
             
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
                array( 'db' => 'plafond',  'field' => 'plafond',   'dt' => $i++ ),
                array( 'db' => 'plafondEmpye',  'field' => 'plafondEmpye',   'dt' => $i++ )
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