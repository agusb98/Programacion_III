<?php 

function validarString($string, $len){
    if($len == strlen($string)){
        if($string == "Recuperatorio" || $string == "Parcial" || $string == "Programacion")
            return 1;
    }
    return 0;
}

echo validarString("Hola", 7), "<br>";
echo validarString("Parcial", 7), "<br>";
echo validarString("Programacion", 15), "<br>";
?>