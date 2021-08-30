<?php 

class DevisAchatProduit { 

	private $devis;
	private $produit;
	private $prix;
	private $quantite;



	function __construct($devis, $produit, $prix, $quantite ){
		$this->devis = $devis;
		$this->produit = $produit;
		$this->prix = $prix;
		$this->quantite = $quantite;
	}


	function getDevis () {
		 return $this->devis;
	}

	function setDevis ($devis) {
		 $this->devis = $devis;
	}

	function getProduit () {
		 return $this->produit;
	}

	function setProduit ($produit) {
		 $this->produit = $produit;
	}

	function getPrix () {
		 return $this->prix;
	}

	function setPrix ($prix) {
		 $this->prix = $prix;
	}

	function getQuantite () {
		 return $this->quantite;
	}

	function setQuantite ($quantite) {
		 $this->quantite = $quantite;
	}

}