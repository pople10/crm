<?php


class AvoirAchat
{
    private $id;
    private $fournisseur;
    private $date;
    private $type;
    private $bon;

    /**
     * AvoirAchat constructor.
     * @param $id
     * @param $fournisseur
     * @param $date
     * @param $type
     * @param $bon
     */
    public function __construct($id, $fournisseur, $date, $type, $bon)
    {
        $this->id = $id;
        $this->fournisseur = $fournisseur;
        $this->date = $date;
        $this->type = $type;
        $this->bon = $bon;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
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


}