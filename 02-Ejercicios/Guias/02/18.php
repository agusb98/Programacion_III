<?php 

function esPar($num){
    if($num % 2 == 0){
        return true;
    }

    return false;
}

function esImpar($num){
    return !esPar($num);
}

if(EsPar(4)){
    echo "es par", "<br>";
}else{
    echo "es impar", "<br>";
}
if(EsPar(7)){
    echo "es par", "<br>";
}else{
    echo "es impar", "<br>";
}
if(EsImpar(4)){
    echo "es impar", "<br>";
}else{
    echo "es par", "<br>";
}
?>