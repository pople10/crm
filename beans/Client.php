<?php

class Client {

    private $id;
    private $nom;
    private $prenom;
    private $civilite;
    private $type;
    private $adresse;
    private $cp;
    private $ville;
    private $pays;
    private $ice;
    private $codeIf;
    private $telephone;
    private $gsm;
    private $fax;
    private $email;
    private $web;
    private $reglement;
    private $mode;
    private $dateCreation;
    private $categorie;
    private $suivi;
    private $recouvreur;
    private $activite;
    private $region;
    private $origine;
    private $devise;
    private $compteTiers;
    private $compteComptable;
    private $plafond;
    private $plafondEmpye;
    private $douteux;
    private $dateLimit;

    function __construct($id, $nom, $prenom, $civilite, $type, $adresse, $cp, $ville, $pays, $ice, $codeIf, $telephone, $gsm, $fax, $email, $web, $reglement, $mode, $dateCreation, $categorie, $suivi, $recouvreur, $activite, $region, $origine, $devise, $compteTiers, $compteComptable, $plafond, $plafondEmpye, $douteux,$dateLimit) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->civilite = $civilite;
        $this->type = $type;
        $this->adresse = $adresse;
        $this->cp = $cp;
        $this->ville = $ville;
        $this->pays = $pays;
        $this->ice = $ice;
        $this->codeIf = $codeIf;
        $this->telephone = $telephone;
        $this->gsm = $gsm;
        $this->fax = $fax;
        $this->email = $email;
        $this->web = $web;
        $this->reglement = $reglement;
        $this->mode = $mode;
        $this->dateCreation = $dateCreation;
        $this->categorie = $categorie;
        $this->suivi = $suivi;
        $this->recouvreur = $recouvreur;
        $this->activite = $activite;
        $this->region = $region;
        $this->origine = $origine;
        $this->devise = $devise;
        $this->compteTiers = $compteTiers;
        $this->compteComptable = $compteComptable;
        $this->plafond = $plafond;
        $this->plafondEmpye = $plafondEmpye;
        $this->douteux = $douteux;
        $this->dateLimit=$dateLimit;
    }

    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getCivilite() {
        return $this->civilite;
    }

    function getType() {
        return $this->type;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getCp() {
        return $this->cp;
    }

    function getVille() {
        return $this->ville;
    }

    function getPays() {
        return $this->pays;
    }

    function getIce() {
        return $this->ice;
    }

    function getCodeIf() {
        return $this->codeIf;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function getGsm() {
        return $this->gsm;
    }

    function getFax() {
        return $this->fax;
    }

    function getEmail() {
        return $this->email;
    }

    function getWeb() {
        return $this->web;
    }

    function getReglement() {
        return $this->reglement;
    }

    function getMode() {
        return $this->mode;
    }

    function getText1() {
        return $this->text1;
    }

    function getText2() {
        return $this->text2;
    }

    function getText3() {
        return $this->text3;
    }

    function getDateCreation() {
        return $this->dateCreation;
    }

    function getCategorie() {
        return $this->categorie;
    }

    function getSuivi() {
        return $this->suivi;
    }

    function getRecouvreur() {
        return $this->recouvreur;
    }

    function getActivite() {
        return $this->activite;
    }

    function getRegion() {
        return $this->region;
    }

    function getOrigine() {
        return $this->origine;
    }

    function getDevise() {
        return $this->devise;
    }

    function getCompteTiers() {
        return $this->compteTiers;
    }

    function getCompteComptable() {
        return $this->compteComptable;
    }

    function getPlafond() {
        return $this->plafond;
    }

    function getPlafondEmpye() {
        return $this->plafondEmpye;
    }

    function getDouteux() {
        return $this->douteux;
    }
    
    function getDateLimit()
    {
        return $this->dateLimit;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setCivilite($civilite) {
        $this->civilite = $civilite;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setCp($cp) {
        $this->cp = $cp;
    }

    function setVille($ville) {
        $this->ville = $ville;
    }

    function setPays($pays) {
        $this->pays = $pays;
    }

    function setIce($ice) {
        $this->ice = $ice;
    }

    function setCodeIf($codeIf) {
        $this->codeIf = $codeIf;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function setGsm($gsm) {
        $this->gsm = $gsm;
    }

    function setFax($fax) {
        $this->fax = $fax;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setWeb($web) {
        $this->web = $web;
    }

    function setReglement($reglement) {
        $this->reglement = $reglement;
    }

    function setMode($mode) {
        $this->mode = $mode;
    }

    function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }

    function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    function setSuivi($suivi) {
        $this->suivi = $suivi;
    }

    function setRecouvreur($recouvreur) {
        $this->recouvreur = $recouvreur;
    }

    function setActivite($activite) {
        $this->activite = $activite;
    }

    function setRegion($region) {
        $this->region = $region;
    }

    function setOrigine($origine) {
        $this->origine = $origine;
    }

    function setDevise($devise) {
        $this->devise = $devise;
    }

    function setCompteTiers($compteTiers) {
        $this->compteTiers = $compteTiers;
    }

    function setCompteComptable($compteComptable) {
        $this->compteComptable = $compteComptable;
    }

    function setPlafond($plafond) {
        $this->plafond = $plafond;
    }

    function setPlafondEmpye($plafondEmpye) {
        $this->plafondEmpye = $plafondEmpye;
    }

    function setDouteux($douteux) {
        $this->douteux = $douteux;
    }
    
    function setDateLimit($dateLimit)
    {
        $this->dateLimit=$dateLimit;
    }


}
