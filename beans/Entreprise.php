<?php


class Entreprise
{
    private $id;
    private $nomFr;
    private $nomAr;
    private $indicationFr;
    private $indicationAr;
    private $code_ice;
    private $code_if;
    private $adresse;
    private $ville;
    private $telephone;
    private $fax;
    private $remise;
    private $logo;

    /**
     * Entreprise constructor.
     * @param $id
     * @param $nomFr
     * @param $nomAr
     * @param $indicationFr
     * @param $indicationAr
     * @param $code_ice
     * @param $code_if
     * @param $adresse
     * @param $ville
     * @param $telephone
     * @param $fax
     * @param $logo
     */
    public function __construct($id, $nomFr, $nomAr, $indicationFr, $indicationAr, $code_ice, $code_if, $adresse, $ville, $telephone, $fax,$remise, $logo)
    {
        $this->id = $id;
        $this->nomFr = $nomFr;
        $this->nomAr = $nomAr;
        $this->indicationFr = $indicationFr;
        $this->indicationAr = $indicationAr;
        $this->code_ice = $code_ice;
        $this->code_if = $code_if;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->telephone = $telephone;
        $this->fax = $fax;
        $this->remise = $remise;
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getRemise()
    {
        return $this->remise;
    }
    public function getCodeIce()
    {
        return $this->code_ice;
    }

    /**
     * @param mixed $code_ice
     */
    public function setCodeIce($code_ice)
    {
        $this->code_ice = $code_ice;
    }

    /**
     * @return mixed
     */
    public function getCodeIf()
    {
        return $this->code_if;
    }

    /**
     * @param mixed $code_if
     */
    public function setCodeIf($code_if)
    {
        $this->code_if = $code_if;
    }


    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getIndicationFr()
    {
        return $this->indicationFr;
    }

    /**
     * @param mixed $indicationFr
     */
    public function setIndicationFr($indicationFr)
    {
        $this->indicationFr = $indicationFr;
    }

    /**
     * @return mixed
     */
    public function getIndicationAr()
    {
        return $this->indicationAr;
    }

    /**
     * @param mixed $indicationAr
     */
    public function setIndicationAr($indicationAr)
    {
        $this->indicationAr = $indicationAr;
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
    public function getNomFr()
    {
        return $this->nomFr;
    }

    /**
     * @param mixed $nomFr
     */
    public function setNomFr($nomFr)
    {
        $this->nomFr = $nomFr;
    }

    /**
     * @return mixed
     */
    public function getNomAr()
    {
        return $this->nomAr;
    }

    /**
     * @param mixed $nomAr
     */
    public function setNomAr($nomAr)
    {
        $this->nomAr = $nomAr;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }
    
    public function setRemise($telephone)
    {
        $this->remise = $remise;
    }
    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }




}