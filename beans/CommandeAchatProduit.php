<?php


class CommandeAchatProduit
{
    private $commande;
    private $produit;
    private $prix;
    private $quantite;

    /**
     * CommandeAchatProduit constructor.
     * @param $commande
     * @param $produit
     * @param $prix
     * @param $quantite
     */
    public function __construct($commande, $produit, $prix, $quantite)
    {
        $this->commande = $commande;
        $this->produit = $produit;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
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