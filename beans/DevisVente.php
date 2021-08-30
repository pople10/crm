<?php

class DevisVente {

    private $id;
    private $client;
    private $date;
    private $type;

    function __construct($id, $client, $date, $type) {
        $this->id = $id;
        $this->client = $client;
        $this->date = $date;
        $this->type = $type;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getClient() {
        return $this->client;
    }

    function setClient($client) {
        $this->client = $client;
    }

    function getDate() {
        return $this->date;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
    }

}
