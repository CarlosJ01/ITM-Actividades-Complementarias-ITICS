<?php
/* Funcion que genera password aleatorios para los usuarios */
function generatePassword($length){
        $key = "";
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
        $max = strlen($pattern)-1;
        for($i = 0; $i < $length; $i++){
            $key .= substr($pattern, mt_rand(0,$max), 1);
        }
        return $key;
    }
?>