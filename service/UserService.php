<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserService
 *
 * @author a
 */
include_once "bcrypt.php";
include_once 'beans/User.php';
include_once 'dao/IDao.php';
include_once 'connexion/Connexion.php';
class UserService implements IDao {

    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $bcrypt = new Bcrypt(10);
        $query = "INSERT INTO User VALUES (NULL,?, ?,?,?,?,NULL,NULL)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom(), $o->getPrenom(),$o->getTelephone(), $o->getEmail(),$bcrypt->hash($o->getPassword()))) or die('Error');
    }

    public function delete($o) {
        $query = "DELETE FROM User WHERE id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o)) or die("erreur delete");
    }

    public function findAll() {
        $query = "select id,nom,prenom,telephone,email,photo from User";
        $req = $this->connexion->getConnexion()->query($query);
        $users = $req->fetchAll(PDO::FETCH_OBJ);
        return $users;
    }


    public function findById($id) {
        $query = "select * from User where id =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }
    
    public function emailExists($email,$currentUser) {
        $query = "select * from User where email=? and id != ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($email,$currentUser));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }
    
    public function findByEmail($email) {
        $query = "select u.*, r.nom as role from User u inner join Role r on u.role = r.id  where email =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($email));
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function findUserPrivilege($user) {
        $query = "SELECT * FROM UserPrivilege where user_id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($user));
        $res = $req->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function update($o) {
        $query = "UPDATE User SET nom = ?, prenom = ? , telephone = ? , email = ?  where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom(), $o->getPrenom(),$o->getTelephone(), $o->getEmail(), $o->getId())) or die('Error');
    }
    
    public function updatePhoto($o)
    {
        $r = true;
        $query = "UPDATE User SET photo = ?  where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getPhoto(),$o->getId())) or $r = false;
        return $r;

    }

    public function updatePassword($o) {
        $bcrypt = new Bcrypt(10);
        $query = "UPDATE User SET password = ?  where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($bcrypt->hash($o->getPassword()), $o->getId())) or die('Error');
    }
    public function cryptAllPassword()
    {   
        $query="SELECT id,password FROM User";
        $req = $this->connexion->getConnexion()->query($query);
        $res = array($req->fetchAll(PDO::FETCH_OBJ));
        foreach($res[0] as $key=>$val)
        {   $id=0;
            $password="";
            foreach($val as $key1=>$val1)
            {
                if($key1=="id")
                    $id=$val1;
                else
                    $password=$val1;
            }
            $bcrypt = new Bcrypt(10);
            $hash = $bcrypt->hash($password);
            $query = "UPDATE User SET password = ?  where id=?";
            $req1 = $this->connexion->getConnexion()->prepare($query);
            $req1->execute(array($hash,$id)) or die('Error');
        }
    }

}
