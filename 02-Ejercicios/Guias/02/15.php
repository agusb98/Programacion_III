<?php 

function potencia(){
    for ($i=1; $i < 5; $i++) {     //primero los numeros 
        echo "<b>", $i, "</b>: ";
        for ($j=0; $j < 4 ; $j++) {     //y sus cuatro potencias
            echo pow($i, $j), " ";
        }
        echo "<br>";
    }
}

Potencia();
?>
