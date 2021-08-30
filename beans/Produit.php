<?php

class Produit{

	private $reference;
	private $designation_vente;
	private $designation_achat;
	private $appellation;
	private $description;
	private $image;
	private $tarif_ht;
	private $tva;
	private $tarif_ttc;
	private $en_promotion;
	private $enp_de;
	private $enp_au;
	private $prix_promo;
	private $remise_n1;
	private $remise_n2;
	private $remise_n3;
	private $remise_n4;
	private $categorie;
	private $famille;
	private $sous_famille;
	private $marque;
	private $gere_en_stock;
	private $quantite_en_stock;
	private $stock_alerte;
	private $quantite_max;
	private $unite_principale;
	private $unite_vente;
	private $c_longueur;
	private $c_largeur;
	private $c_epaisseur;
	private $statut;

    /**
     * Produit constructor.
     * @param $reference
     * @param $designation_vente
     * @param $designation_achat
     * @param $description
     * @param $image
     * @param $tarif_ht
     * @param $tva
     * @param $tarif_ttc
     * @param $en_promotion
     * @param $enp_de
     * @param $enp_au
     * @param $prix_promo
     * @param $remise_n1
     * @param $remise_n2
     * @param $remise_n3
     * @param $remise_n4
     * @param $categorie
     * @param $famille
     * @param $sous_famille
     * @param $marque
     * @param $gere_en_stock
     * @param $type_gestion
     * @param $stock_alerte
     * @param $quantite_max
     * @param $unite_principale
     * @param $unite_vente
     * @param $c_longueur
     * @param $c_largeur
     * @param $c_epaisseur
     * @param $statut
     */
    public function __construct($reference, $designation_vente, $designation_achat,$appellation, $description, $image, $tarif_ht, $tva, $tarif_ttc, $en_promotion, $enp_de, $enp_au, $prix_promo, $remise_n1, $remise_n2, $remise_n3, $remise_n4, $categorie, $famille, $sous_famille, $marque, $gere_en_stock, $quantite_en_stock, $stock_alerte, $quantite_max, $unite_principale, $unite_vente, $c_longueur, $c_largeur, $c_epaisseur, $statut)
    {
        $this->reference = $reference;
        $this->designation_vente = $designation_vente;
        $this->designation_achat = $designation_achat;
        $this->appellation=$appellation;
        $this->description = $description;
        $this->image = $image;
        $this->tarif_ht = $tarif_ht;
        $this->tva = $tva;
        $this->tarif_ttc = $tarif_ttc;
        $this->en_promotion = $en_promotion;
        $this->enp_de = $enp_de;
        $this->enp_au = $enp_au;
        $this->prix_promo = $prix_promo;
        $this->remise_n1 = $remise_n1;
        $this->remise_n2 = $remise_n2;
        $this->remise_n3 = $remise_n3;
        $this->remise_n4 = $remise_n4;
        $this->categorie = $categorie;
        $this->famille = $famille;
        $this->sous_famille = $sous_famille;
        $this->marque = $marque;
        $this->gere_en_stock = $gere_en_stock;
        $this->quantite_en_stock = $quantite_en_stock;
        $this->stock_alerte = $stock_alerte;
        $this->quantite_max = $quantite_max;
        $this->unite_principale = $unite_principale;
        $this->unite_vente = $unite_vente;
        $this->c_longueur = $c_longueur;
        $this->c_largeur = $c_largeur;
        $this->c_epaisseur = $c_epaisseur;
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getQuantiteMax()
    {
        return $this->quantite_max;
    }

    /**
     * @param mixed $quantite_max
     */
    public function setQuantiteMax($quantite_max)
    {
        $this->quantite_max = $quantite_max;
    }



    function getReference () {
		 return $this->reference;
	}

	function setReference ($reference) {
		 $this->reference = $reference;
	}

	function getDesignation_vente () {
		 return $this->designation_vente;
	}

	function setDesignation_vente ($designation_vente) {
		 $this->designation_vente = $designation_vente;
	}

	function getDesignation_achat () {
		 return $this->designation_achat;
	}

	function setDesignation_achat ($designation_achat) {
		 $this->designation_achat = $designation_achat;
	}
    
    function getAppellation () {
		 return $this->appellation;
	}
    
    function setAppellation ($appellation) {
		  $this->appellation=$appellation;
	}
	
	function getDescription () {
		 return $this->description;
	}

	function setDescription ($description) {
		 $this->description = $description;
	}

	function getImage () {
		 return $this->image;
	}

	function setImage ($image) {
		 $this->image = $image;
	}

	function getTarif_ht () {
		 return $this->tarif_ht;
	}

	function setTarif_ht ($tarif_ht) {
		 $this->tarif_ht = $tarif_ht;
	}

	function getTva () {
		 return $this->tva;
	}

	function setTva ($tva) {
		 $this->tva = $tva;
	}

	function getTarif_ttc () {
		 return $this->tarif_ttc;
	}

	function setTarif_ttc ($tarif_ttc) {
		 $this->tarif_ttc = $tarif_ttc;
	}

	function getEn_promotion () {
		 return $this->en_promotion;
	}

	function setEn_promotion ($en_promotion) {
		 $this->en_promotion = $en_promotion;
	}

	function getEnp_de () {
		 return $this->enp_de;
	}

	function setEnp_de ($enp_de) {
		 $this->enp_de = $enp_de;
	}

	function getEnp_au () {
		 return $this->enp_au;
	}

	function setEnp_au ($enp_au) {
		 $this->enp_au = $enp_au;
	}

	function getPrix_promo () {
		 return $this->prix_promo;
	}

	function setPrix_promo ($prix_promo) {
		 $this->prix_promo = $prix_promo;
	}

	function getRemise_n1 () {
		 return $this->remise_n1;
	}

	function setRemise_n1 ($remise_n1) {
		 $this->remise_n1 = $remise_n1;
	}

	function getRemise_n2 () {
		 return $this->remise_n2;
	}

	function setRemise_n2 ($remise_n2) {
		 $this->remise_n2 = $remise_n2;
	}

	function getRemise_n3 () {
		 return $this->remise_n3;
	}

	function setRemise_n3 ($remise_n3) {
		 $this->remise_n3 = $remise_n3;
	}

	function getRemise_n4 () {
		 return $this->remise_n4;
	}

	function setRemise_n4 ($remise_n4) {
		 $this->remise_n4 = $remise_n4;
	}

	function getCategorie () {
		 return $this->categorie;
	}

	function setCategorie ($categorie) {
		 $this->categorie = $categorie;
	}

	function getFamille () {
		 return $this->famille;
	}

	function setFamille ($famille) {
		 $this->famille = $famille;
	}

	function getSous_famille () {
		 return $this->sous_famille;
	}

	function setSous_famille ($sous_famille) {
		 $this->sous_famille = $sous_famille;
	}

	function getMarque () {
		 return $this->marque;
	}

	function setMarque ($marque) {
		 $this->marque = $marque;
	}

	function getGere_en_stock () {
		 return $this->gere_en_stock;
	}

	function setGere_en_stock ($gere_en_stock) {
		 $this->gere_en_stock = $gere_en_stock;
	}

    /**
     * @return mixed
     */
    public function getQuantiteEnStock()
    {
        return $this->quantite_en_stock;
    }

    /**
     * @param mixed $quantite_en_stock
     */
    public function setQuantiteEnStock($quantite_en_stock)
    {
        $this->quantite_en_stock = $quantite_en_stock;
    }

	function getStock_alerte () {
		 return $this->stock_alerte;
	}

	function setStock_alerte ($stock_alerte) {
		 $this->stock_alerte = $stock_alerte;
	}

	function getUnite_principale () {
		 return $this->unite_principale;
	}

	function setUnite_principale ($unite_principale) {
		 $this->unite_principale = $unite_principale;
	}

	function getUnite_vente () {
		 return $this->unite_vente;
	}

	function setUnite_vente ($unite_vente) {
		 $this->unite_vente = $unite_vente;
	}

	function getC_longueur () {
		 return $this->c_longueur;
	}

	function setC_longueur ($c_longueur) {
		 $this->c_longueur = $c_longueur;
	}

	function getC_largeur () {
		 return $this->c_largeur;
	}

	function setC_largeur ($c_largeur) {
		 $this->c_largeur = $c_largeur;
	}

	function getC_epaisseur () {
		 return $this->c_epaisseur;
	}

	function setC_epaisseur ($c_epaisseur) {
		 $this->c_epaisseur = $c_epaisseur;
	}

	function getStatut () {
		 return $this->statut;
	}

	function setStatut ($statut) {
		 $this->statut = $statut;
	}
}