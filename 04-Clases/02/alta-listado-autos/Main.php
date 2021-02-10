<?php
require "./Clases/Auto.php";
require "./Clases/Archivos.php";
require "./Clases/Controller.php";
require "./Clases/POST.php";
require "./Clases/GET.php";

/**
 * METODOS
 * GET: obtener recursos
 * POST: crear recursos
 * PUT: modificar recursos
 * DELETE: borrar recursos
 */

$archivoTxt = "Archivos/listado.txt";
$archivoJson = "Archivos/listadoJson.txt";

$method = $_SERVER['REQUEST_METHOD'] ?? '';
$path = $_SERVER['PATH_INFO'] ?? '';

//Los recursos pueden llegar de distintos Métodos
//Tambien chequeo si el dato recibido por POST o GET

switch($path)
{
    case "/see":
        if(file_exists($archivoTxt)){
            Controller::MostrarLista($archivoTxt);
        }
        else
            printf("Archivo no Existente");
    break;
    case "/add":
        if(Controller::Guardar($archivoTxt, $method)){
            echo "Dato guardado exitosamente en el archivo con ruta: $archivoTxt";
        }
    break;
    case "/search=patente":
        Controller::BuscarPorPatente($archivoTxt, $method);
    break;
    case "/see/json":
        if(file_exists($archivoJson)){
            Controller::MostrarListaEnJson($archivoJson);
        }
        else
            printf("Archivo no Existente");
    break;
    case "/add/json":
        if(Controller::GuardarEnJson($archivoJson, $method)){
            echo "Dato guardado exitosamente en el archivo con ruta: $archivoJson";
        }
    break;
    case "/search/json":
        Controller::BuscarEnJson($archivoJson, $method);
    break;
    default:
    break;
}
?>