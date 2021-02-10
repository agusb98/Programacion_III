<?php

//PDO: conexion a base de Datos (phpmyadmin)

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bdusuarios;charset=utf8','root','');
    $query = $pdo->query("SELECT * FROM persona");
    
    //echo "Filas: " . $query->rowCount();    //Muestra cantidad de Filas
    /*
    $result = $query->fetchAll();           //Muestra todo lo que haya en formato array
    
    
    foreach ($result as $key => $value) {
        echo $key . " " . $value["nombre"] . "<br>";
    }
    */
    
    /*
    //Para no obtener todo el pedaso de dato en memoria, es preferible usar:
    
    while ($fila = $query->fetch()) {
        echo $fila[1] . "<br>";
    }
    */
    
    //LAZY: los convierte a objetos y facilita su manejo (Mas recomendable)
    
    while ($fila = $query->fetch(PDO::FETCH_LAZY)) {
        echo $fila->nombre . "<br>";
    }
} 
catch (\Throwable $th) {
    echo $th->getMessage();
}

////////////////////////////////////////////////////////////////////////////////

//La idea ahora es analizar los datos que me enviaran para que no me rompan el codigo

$id = $_GET["id"];
try {
    $pdo = new PDO('mysql:host=localhost;dbname=bdusuarios;charset=utf8','root','');
    $query = $pdo->prepare("SELECT * FROM persona WHERE id=:id");
    $query->bindParam(":id", $id);

    //Tambien puedo restringuir string, 5 es la cantidad max de caracteres
    
    /*
    $query->bindParam(":id", $id, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 5); 
    */
    
    $result = $query->execute();
    var_dump($result);
} 
catch (\Throwable $th) {
    echo $th->getMessage();
}