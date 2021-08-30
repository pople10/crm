<?php 

class DevisVenteProduit { 

	private $devis;
	private $produit;
	private $prix;
	private $quantite;
	private $remise;



	function __construct($devis, $produit, $prix, $quantite,$remise){
		$this->devis = $devis;
		$this->produit = $produit;
		$this->prix = $prix;
		$this->quantite = $quantite;
		$this->remise = $remise;
	}

    /**
     * @return mixed
     */
    public function getRemise()
    {
        return $this->remise;
    }

    /**
     * @param mixed $remise
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;
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