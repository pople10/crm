<?php


class FactureAchatProduit
{
    private $facture;
    private $produit;
    private $prix;
    private $quantite;

    /**
     * FactureAchatProduit constructor.
     * @param $facture
     * @param $produit
     * @param $prix
     * @param $quantite
     */
    public function __construct($facture, $produit, $prix, $quantite)
    {
        $this->facture = $facture;
        $this->produit = $produit;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * @param mixed $facture
     */
    public function setFacture($facture)
    {
        $this->facture = $facture;
    }

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }


}