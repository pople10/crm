<?php


class BonAchatProduit
{
    private $bon;
    private $produit;
    private $prix;
    private $quantite;

    /**
     * BonAchatProduit constructor.
     * @param $bon
     * @param $produit
     * @param $prix
     * @param $quantite
     */
    public function __construct($bon, $produit, $prix, $quantite)
    {
        $this->bon = $bon;
        $this->produit = $produit;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getBon()
    {
        return $this->bon;
    }

    /**
     * @param mixed $bon
     */
    public function setBon($bon)
    {
        $this->bon = $bon;
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