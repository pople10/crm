<?php


chdir("..");
ini_set('display_errors', 1);

include_once 'service/UserService.php';
include_once 'service/bcrypt.php';
$bcrypt = new Bcrypt(10);


if(!isset($_SESSION['user_id']))
    if(isset($_COOKIE["SESFLAG"])&&!empty($_COOKIE["SESFLAG"]))
    {
        $us = new UserService();
        $user= $us->findById($_COOKIE["SESFLAG"]);
        session_start();
        $u = new User($user->id, $user->nom, $user->prenom, $user->telephone, $user->email, $user->password, $user->photo, $user->role);
            $_SESSION['user'] = $u;
            $_SESSION['user_id'] = $u->getId();
            $_SESSION['privileges'] = $us->findUserPrivilege($user->id);
        echo "exist";
    }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $us = new UserService();
    /* Attention ne pas touchez cela
    $us->cryptAllPassword();*/
    $user = $us->findByEmail($email);
    if (!empty($user)) {
        if ($bcrypt->verify($password,$user->password)) {
            session_start();
            $u = new User($user->id, $user->nom, $user->prenom, $user->telephone, $user->email, $user->password, $user->photo, $user->role);
            $_SESSION['user'] = $u;
            $_SESSION['user_id'] = $u->getId();
            $_SESSION['privileges'] = $us->findUserPrivilege($user->id);
            if($rememberMe=="true")
                {setcookie("SESFLAG",$u->getId(),2147483647);}
            echo '../public/index.php';
        } else {
            echo '../index.html';
        }
    }else {
         echo '../index.html';
    }
}





