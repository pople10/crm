<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

chdir('..');
ini_set('display_errors', 1);
include_once 'service/UserService.php';
extract($_POST);
$es = new UserService();
include_once 'service/bcrypt.php';
$bcrypt = new Bcrypt(10);

$response = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($op)) {
        if (($op == "add") && !empty($email)) {
            $password = $bcrypt->hash($password);
            $es->create(new User(0,$nom,$prenom,$telephone,$email,$password,NULL,NULL));
            $response = true;
        } else if ($op == "delete") {
            $es->delete($id);
            $response = false;
        } else if ($op == "update") {
            header('Content-type: application/json');
            echo json_encode($es->findById($id));
            $response = false;
        }else if ($op == "checkPassword") {
            header('Content-type: application/json');
            $user = $es->findById($id);
            if($user != null && $bcrypt->verify($password,$user->password))
                echo json_encode(true);
            else
                echo json_encode(false);
            $response = false;
        }else if ($op == "newUpdate") {
            $password = $bcrypt->hash($password);
            $user = new User($id,$nom,$prenom,$telephone,$email,$password,NULL,NULL);
            $es->update($user);
            if($password != "")
                $es->updatePassword($user);
            $response = true;
        }else if ($op == "updateCurrentUser") {
            $user = new User($_SESSION['user_id'],$nom,$prenom,$telephone,$email,null,NULL,NULL);
            $es->update($user);
            $user = $es->findById($_SESSION['user_id']);
            $u = new User($user->id, $user->nom, $user->prenom, $user->telephone, $user->email, $user->password, $user->photo, $user->role);
            $_SESSION['user'] = $u;
            $response = true;
        } else if ($op == "currentUser") {
            header('Content-type: application/json');
            $us = $es->findById($_SESSION['user_id']);
            unset($us->password,$us->role,$us->id);
            echo json_encode($us);
            $response = false;
        } else if ($op == "emailExists") {
            header('Content-type: application/json');
            $us = $es->emailExists($email,$_SESSION['user_id']) ? true : false;
            echo json_encode($us);
            $response = false;
        } else if ($op == "updatePhoto"){
            if (!$es->updatePhoto(new User($_SESSION['user_id'],null,null,null,null,null,$photo,NULL)))
                $response = false;
            else {
                $user = $es->findById($_SESSION['user_id']);
                $u = new User($user->id, $user->nom, $user->prenom, $user->telephone, $user->email, $user->password, $user->photo, $user->role);
                $_SESSION['user'] = $u;
            }
        } else if ($op == "updatePassword") {
            header('Content-type: application/json');
            $user = $es->findById($_SESSION['user_id']);
            if($user != null && $bcrypt->verify($old_password,$user->password)){
                $user = new User($_SESSION['user_id'],null,null,null,null,$new_password,NULL,NULL);
                $es->updatePassword($user);
                echo json_encode(array("response" => true , "message" => "Modifié avec succès"));
            }
            else
                echo json_encode(array("response" => false , "message" => "Mot de passe actuel invalide."));
            $response = false;
        }
    }
}

if ($response == true) {
    header('Content-type: application/json');
    echo json_encode(array("response" => $response, "data" => $es->findAll()));
}

}
