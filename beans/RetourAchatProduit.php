<?php


class RetourAchatProduit
{
    private $retour;
    private $produit;
    private $prix;
    private $quantite;

    /**
     * RetourAchatProduit constructor.
     * @param $retour
     * @param $produit
     * @param $prix
     * @param $quantite
     */
    public function __construct($retour, $produit, $prix, $quantite)
    {
        $this->retour = $retour;
        $this->produit = $produit;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getRetour()
    {
        return $this->retour;
    }

    /**
     * @param mixed $retour
     */
    public function setRetour($retour)
    {
        $this->retour = $retour;
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