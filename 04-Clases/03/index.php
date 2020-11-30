<?php
require "./Clases/Archivo.php";

/**
* Subir una imagen
* Validar que sea imagen
* Validar que sea menor a 3,5mb
* Cambiarle el nombre por uno unico
*/   
    
if(Archivo::Mover()){
    echo "Movido Exitosamente";
}
    
    
if(Archivo::Borrar()){
    echo "Borrado Exitosamente";
}
    
?>