<?php

/* Controller Security */ 
session_start();
if (isset($_SESSION['user'])) {

/*$path = '/home2/toubkali/public_html/crm';

$dirs = array();

// directory handle
$dir = dir($path);

while (false !== ($entry = $dir->read())) {
    if ($entry != '.' && $entry != '..') {
       if (is_dir($path . '/' .$entry)) {
            $dirs[] = $entry.' d'; 
       }else
         $dirs[] = $entry.' f'; 
    }
}


header('Content-type: application/json');
echo json_encode($dirs);

 function get_all_directory_and_files($dir){
 
     $dh = new DirectoryIterator($dir);   
     // Dirctary object 
     foreach ($dh as $item) {
         if (!$item->isDot()) {
            if ($item->isDir()) {
                get_all_directory_and_files("$dir/$item");
            } else {
                echo $dir . "/" . $item->getFilename();
                echo "<br>";
            }
         }
      }
   }
 
  # Call function 
  
  get_all_directory_and_files("/home2/toubkali/public_html/crm");*/
  
  $count = 0;
  
  echo $count++;
  echo '<br>';
  echo $count++;
  
}