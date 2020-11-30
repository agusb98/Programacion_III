<?php 

function invertirString($string){
    for ($i = strlen($string) - 1; $i >= 0; $i--) {
        echo $string[$i];
    }
}

invertirString("Hola");
?>