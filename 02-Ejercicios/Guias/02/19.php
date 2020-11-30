<?php

require "19\Rectangulo.php";
require "19\Triangulo.php";

    $rectangulo = new Rectangulo(5, 2);
    echo $rectangulo->ToString();
    echo "<br><br>";
    echo $rectangulo->Dibujar();

    $triangulo = new Triangulo(5, 2);
    echo $triangulo->ToString();
    echo "<br><br>";
    echo $triangulo->Dibujar();
?>