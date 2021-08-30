<?php


class RetourAchat
{
    private $id;
    private $fournisseur;
    private $date_creation;
    private $date_envoi;
    private $etat;

    /**
     * RetourAchat constructor.
     * @param $id
     * @param $fournisseur
     * @param $date_creation
     * @param $date_envoi
     * @param $etat
     */
    public function __construct($id, $fournisseur, $date_creation, $date_envoi, $etat)
    {
        $this->id = $id;
        $this->fournisseur = $fournisseur;
        $this->date_creation = $date_creation;
        $this->date_envoi = $date_envoi;
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
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return mixed
     */
    public function getDateEnvoi()
    {
        return $this->date_envoi;
    }

    /**
     * @param mixed $date_envoi
     */
    public function setDateEnvoi($date_envoi)
    {
        $this->date_envoi = $date_envoi;
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