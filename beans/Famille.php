<?php


class Famille {
    private $id;
    private $nom;
    private $famille;
    
    function __construct($id, $nom, $famille) {
        $this->id = $id;
        $this->nom = $nom;
        $this->famille = $famille;
    }
    
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getFamille() {
        return $this->famille;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setFamille($famille) {
        $this->famille = $famille;
    }



}
