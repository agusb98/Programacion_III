<?php
class Controller
{
    public function MostrarLista($archivo)
    {
        $list = Archivos::Deserealizacion($archivo);
        Auto::MostrarLista($list);
    }

    public function MostrarListaEnJson($archivo)
    {
        $list = Archivos::GetAsJson($archivo);
        var_dump($list);
    }
    
    public function Guardar($archivo, $method) : bool
    {
        switch($method)
        {
            case "POST":
                return POST::Guardar($archivo);
            break;
            case "GET":
                return GET::Guardar($archivo);
            break;
            default:
                echo "<br> Path Erroneo <br>";
        }
        return false;
    }

    public static function BuscarPorPatente($archivo, $method)
    {
        switch($method)
        {
            case "POST":
                POST::BuscarPorPatente($archivo);
            break;
            case "GET":
                GET::BuscarPorPatente($archivo);
            break;
            default:
                echo "<br> Path Erroneo <br>";
        }
    }

    public function GuardarEnJson($archivo, $method)
    {
        switch($method)
        {
            case "POST":
                return POST::GuardarEnJson($archivo);
            break;
            case "GET":
                return GET::GuardarEnJson($archivo);
            break;
            default:
                echo "<br> Path Erroneo <br>";
        }
        return false;
    }

    public static function BuscarEnJson($archivo, $method)
    {
        switch($method)
        {
            case "POST":
                POST::BuscarEnJson($archivo);
            break;
            case "GET":
                GET::BuscarEnJson($archivo);
            break;
            default:
                echo "<br> Path Erroneo <br>";
        }
    } 
}   
?>