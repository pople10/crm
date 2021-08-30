<?php


class BonVente
{
    private $id;
    private $client;
    private $date;
    private $etat;
    private $receptionner_par;

    /**
     * CommandeVente constructor.
     * @param $id
     * @param $client
     * @param $date
     * @param $etat
     */
    public function __construct($id, $client, $date, $etat,$receptionner_par)
    {
        $this->id = $id;
        $this->client = $client;
        $this->date = $date;
        $this->etat = $etat;
        $this->receptionner_par = $receptionner_par;
    }

    
    function getReceptionner_par() {
        return $this->receptionner_par;
    }

    function setReceptionner_par($receptionner_par) {
        $this->receptionner_par = $receptionner_par;
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
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
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