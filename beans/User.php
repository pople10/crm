<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author a
 */
class User {
    private $id;
    private $nom;
    private $prenom;
    private $telephone;
    private $email;
    private $password;
    private $photo; 
    private $role;

    function __construct($id, $nom, $prenom, $telephone, $email, $password, $photo, $role) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->password = $password;
        $this->photo = $photo;
        $this->role = $role;
    }
    
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }
    
    function getFullName() {
        return $this->nom . ' ' . $this->prenom;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getPhoto() {
        return $this->photo;
    }

    function getRole() {
        return $this->role;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setPhoto($photo) {
        $this->photo = $photo;
    }

    function setRole($role) {
        $this->role = $role;
    }



}
