<?php

class DevisAchat {

    private $id;
    private $fournisseur;
    private $date;
    private $type;

    function __construct($id, $fournisseur, $date, $type) {
        $this->id = $id;
        $this->fournisseur = $fournisseur;
        $this->date = $date;
        $this->type = $type;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getFournisseur() {
        return $this->fournisseur;
    }

    function setFournisseur($fournisseur) {
        $this->fournisseur = $fournisseur;
    }

    function getDate() {
        return $this->date;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
    }

}
