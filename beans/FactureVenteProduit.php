<?php


class FactureVenteProduit
{
    private $facture;
    private $produit;
    private $prix;
    private $quantite;
    private $remise;

    /**
     * FactureVenteProduit constructor.
     * @param $facture
     * @param $produit
     * @param $prix
     * @param $quantite
     */
    public function __construct($facture, $produit, $prix, $quantite,$remise)
    {
        $this->facture = $facture;
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