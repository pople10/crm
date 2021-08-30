<?php


class PaimentFactureAchat
{
    private $id;
    private $facture;
    private $date;
    private $type;
    private $numero_cheque;
    private $montant;

    /**
     * PaimentFactureAchat constructor.
     * @param $id
     * @param $facture
     * @param $date
     * @param $type
     * @param $numero_cheque
     * @param $montant
     */
    public function __construct($id, $facture, $date, $type, $numero_cheque, $montant)
    {
        $this->id = $id;
        $this->facture = $facture;
        $this->date = $date;
        $this->type = $type;
        $this->numero_cheque = $numero_cheque;
        $this->montant = $montant;
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
    public function getNumeroCheque()
    {
        return $this->numero_cheque;
    }

    /**
     * @param mixed $numero_cheque
     */
    public function setNumeroCheque($numero_cheque)
    {
        $this->numero_cheque = $numero_cheque;
    }

    /**
     * @return mixed
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param mixed $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

}