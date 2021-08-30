<?php
if(isset($_COOKIE["SESFLAG"]))
    {
        unset($_COOKIE["SESFLAG"]);
        setcookie('SESFLAG', null,time() - 3600, '/controller');
        
    }
session_start();
session_unset();
session_destroy();
header("Location:../index.html");
?>
