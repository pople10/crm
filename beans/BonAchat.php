<?php


class BonAchat
{
    private $id;
    private $fournisseur;
    private $date;
    private $etat;

    /**
     * CommandeAchat constructor.
     * @param $id
     * @param $fournisseur
     * @param $date
     * @param $etat
     */
    public function __construct($id, $fournisseur, $date, $etat)
    {
        $this->id = $id;
        $this->fournisseur = $fournisseur;
        $this->date = $date;
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * @param mixed $fournisseur
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }
}