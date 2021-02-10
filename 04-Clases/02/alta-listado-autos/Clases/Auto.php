<?php
class Auto
{
    //Pongo en publico los atributos para poder crearlos en archivo JSON
    public $_patente;
    public $_marca;
    public $_color;
    public $_precio;

    public function __construct($patente = "", $_marca = "", $color = "", $precio = 0.0)
    {
        $this->_patente  = $patente;
        $this->_marca  = $_marca;
        $this->_color  = $color;
        $this->_precio = $precio;
    }

    /**
     * Incrementa el valor del obj Auto al 21%
     * Return: void
     */
    public function AgregarImpuestos($impuesto) : void
    {
        if(is_numeric($impuesto))
            $this->_precio += $impuesto;
    }

    /**
     * Obtiene los datos de un objeto tipo Auto a string
     * Return: string con datos del obj Auto
     */
    public function __ToString() : string
    {
        if($this != NULL){
            return $this->_patente." - ".$this->_marca." - ".$this->_color." - ".$this->_precio."\n";
        }
        else
            return "";
    }

    /**
     * Muestra por pantalla un objeto del tipo Auto
     * Return: void
     */
    public static function MostrarAuto($auto) : void
    {
        if($auto != NULL){
            echo $auto;     //Llama a __ToString()
        }
        else{
            echo "Auto Inexistente<br>";
        }
    }

    /**
     * Muestra por pantalla todos los autos que se encuentren en la lista
     * Return: void
     */
    public function MostrarLista($list) : void
    {
        echo "<b>Muestro LISTA de AUTOS: </b><br><br>";

        foreach($list as $obj){
            echo $obj . "<br>";     //lo mismo que Auto::MostrarAuto($obj);
        }
    }

    /**
     * Verifica igualdad entre dos objetos del tipo Auto mediante su patente
     * Return: true si tienen misma patente, false si no
     */
    public function Equals($objUno, $objDos)
    {
        Auto::ValidarPatente($objUno->_patente);
        Auto::ValidarPatente($objDos->_patente);

        return $objUno == $objDos;
    }

    /**
     * Busca objeto del tipo Auto dentro de la lista mediante su patente y lo muestra por pantalla
     * return: void
     */
    public static function BuscarPorPatente($patente, $list) {

        echo "<b> Muestro (si existe) auto con patente: $patente </b><br><br>";

        if(Auto::ValidarPatente($patente) && $list != NULL)
        {
            foreach($list as $obj){
                if($obj->_patente == $patente)
                    return $obj;
            }
        }
        return NULL;
    }

    /**
     * Busca objeto del tipo Auto dentro de la lista mediante su color y lo muestra por pantalla
     * return: void
     */
    public static function BuscarPorColor($color, $list){

        $newList = array();
        echo "<b> Muestro (si existe) auto con color: $color </b><br><br>";

        if(strlen($color) > 0 && $list != NULL)
        {
            foreach($list as $obj){
                if($obj->_color == $color){
                    array_push($newList, $obj);
                }
            }
            return Auto::MostrarLista($newList);
        }
        return "Color Erroneo";
    }

    /**
     * Valida que la patente corresponda al de un objeto Auto
     */
    public static function ValidarPatente(&$patente) : bool
    {
        $patente = strtoupper($patente);
        $patente = trim($patente, "");
        
        if(strlen($patente) > 5 && strlen($patente) < 8){
            return true;
        }
        return false;
    }

    /**
     * Valida que los datos ingresado por parámetro correspondan al de un objeto Auto no repetido
     */
    public function ValidarAuto(&$patente, $marca, $color, $precio) : bool
    {
        if(Auto::ValidarPatente($patente) && strlen($marca) && strlen($color) && is_numeric($precio))
        {
            return true;
        }
        return false;
    }
}
?>