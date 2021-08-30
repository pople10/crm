<?php


class AvoirVenteProduit
{
    private $avoir;
    private $produit;
    private $prix;
    private $quantite;

    /**
     * AvoirVenteProduit constructor.
     * @param $avoir
     * @param $produit
     * @param $prix
     * @param $quantite
     */
    public function __construct($avoir, $produit, $prix, $quantite)
    {
        $this->avoir = $avoir;
        $this->produit = $produit;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getAvoir()
    {
        return $this->avoir;
    }

    /**
     * @param mixed $avoir
     */
    public function setAvoir($avoir)
    {
        $this->avoir = $avoir;
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