<?php


     $data = file("datos.csv");
     $out = array();
     echo $DELETE= trim($data[0]);
 
     foreach($data as $line) {
     	
         if(trim($line) != $DELETE) {
             $out[] = $line;
         }
       
     }

     $fp = fopen("datos.csv", "w+");
     flock($fp, LOCK_EX);
     foreach($out as $line) {
         fwrite($fp, $line);
     }
     flock($fp, LOCK_UN);
     fclose($fp);  
?> 
