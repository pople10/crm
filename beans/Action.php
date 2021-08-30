<?php

class Action {

    private $id;
    private $date;
    private $dateEchance;
    private $enCharge;
    private $commentaire;
    private $client;
    private $fournisseur;
    private $etat;
    
    function __construct($id, $date, $dateEchance, $enCharge, $commentaire, $client, $fournisseur,$etat) {
        $this->id = $id;
        $this->date = $date;
        $this->dateEchance = $dateEchance;
        $this->enCharge = $enCharge;
        $this->commentaire = $commentaire;
        $this->client = $client;
        $this->fournisseur = $fournisseur;
        $this->etat = $etat;
    }
    
    function getEtat() {
        return $this->etat;
    }

    function getId() {
        return $this->id;
    }

    function getDate() {
        return $this->date;
    }

    function getDateEchance() {
        return $this->dateEchance;
    }

    function getEnCharge() {
        return $this->enCharge;
    }

    function getCommentaire() {
        return $this->commentaire;
    }

    function getClient() {
        return $this->client;
    }

    function getFournisseur() {
        return $this->fournisseur;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setDateEchance($dateEchance) {
        $this->dateEchance = $dateEchance;
    }

    function setEnCharge($enCharge) {
        $this->enCharge = $enCharge;
    }

    function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function setFournisseur($fournisseur) {
        $this->fournisseur = $fournisseur;
    }
    
    function setEtat($etat) {
        $this->etat=$etat;
    }
    



}
