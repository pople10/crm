<?php 

chdir("..");

ini_set('display_errors', 1);

session_start();

if(!empty($_SESSION['user_id']))
	echo "true";
else
	 echo "false";

