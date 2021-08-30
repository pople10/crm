<?php 
    
    $serverName = 'http://'.$_SERVER['SERVER_NAME'];

    class Priviliges{const CONTACTS = 1,VENTES = 2,ACHATS = 3,PRODUITS_ET_SERVICES = 4,COMPTABILITE = 5,ANALYSE = 6,ADMINISTRATION=7,STATISTIQUE=8;}

    define("__PUBLICFOLDER__",$serverName.'/public');
    
    define("__CONTACTSFOLDER__",__PUBLICFOLDER__.'/commercial/contacts');

    define("__SERVICESFOLDER__",__PUBLICFOLDER__.'/commercial/services');

    define("__VENTESFOLDER__",__PUBLICFOLDER__.'/commercial/ventes');

    define("__ACHATSFOLDER__",__PUBLICFOLDER__.'/commercial/achats');

    define("__COMPTAFOLDER__",__PUBLICFOLDER__.'/commercial/comptabilite');

    define("__ANALYSEFOLDER__",__PUBLICFOLDER__.'/commercial/analyse');

    define("__ADMINFOLDER__",__PUBLICFOLDER__.'/commercial/admin');
    
    define("__STATISTIQUEFOLDER__",__PUBLICFOLDER__.'/commercial/statistique');


