<?php 
   function handleError($errno, $errstr, $errfile, $errline) {
      $file = fopen('error.txt', 'wa');
      fwrite($file, $errno.' '.$errstr.' '.$errfile.' '.$errline);
      fclose($file);
   }
   set_error_handler("handleError", E_ALL);
?>