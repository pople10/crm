<?php

set_time_limit(0);

class Connexion {

    private $connexion;
    private $conf;
    public function __construct() {
        $this->conf = array
            (
            'host' => 'localhost',
            'database' => 'crm_app',
            'login' => 'root',
            'password' => ''  
        );   
        try {
            $this->connexion = new PDO('mysql:host=' . $this->conf['host'] . ';dbname=' . $this->conf['database'] . ';', $this->conf['login'], $this->conf['password']);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexion->query("SET NAMES UTF8");
            $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    function getConnexion() {
        return $this->connexion;
    }   
    
    /*
    function getConf(){
        return $this->conf;
    }
    */

}
