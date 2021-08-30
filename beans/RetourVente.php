<?php


class RetourVente
{
    private $id;
    private $client;
    private $date_creation;
    private $date_envoi;
    private $etat;

    /**
     * RetourVente constructor.
     * @param $id
     * @param $client
     * @param $date_creation
     * @param $date_envoi
     * @param $etat
     */
    public function __construct($id, $client, $date_creation, $date_envoi, $etat)
    {
        $this->id = $id;
        $this->client = $client;
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