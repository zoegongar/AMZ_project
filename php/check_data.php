<?php

function check_dni($dni){
    $letter = substr($dni, -1);
    $numbers = substr($dni, 0, -1);
  
    if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers%23, 1) == $letter && strlen($letter) == 1 && strlen ($numbers) == 8 ){
      return true;
    }
    return false;
  }

?>
