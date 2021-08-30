<?php


class AvoirVente
{
    private $id;
    private $client;
    private $date;
    private $type;
    private $bon;

    /**
     * AvoirVente constructor.
     * @param $id
     * @param $client
     * @param $date
     * @param $type
     * @param $bon
     */
    public function __construct($id, $client, $date, $type, $bon)
    {
        $this->id = $id;
        $this->client = $client;
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