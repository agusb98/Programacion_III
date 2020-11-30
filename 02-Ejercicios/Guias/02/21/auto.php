<?php

class Auto{

    private $_marca;
    private $_color;
    private $_precio;
    private $_fecha;

    public function __construct($_marca, $color, $precio = 0.0, $fecha = "00/00/00"){
        $this->_marca  = $_marca;
        $this->_color  = $color;
        $this->_precio = $precio;
        $this->_fecha  = $fecha;
    }

    public function __ToString(){
        return "<br>Marca: " . $this->_marca . "<br>Color: " . $this->_color . "<br>Precio: " . $this->_precio . "<br>Fecha: " . $this->_fecha . "<br>";
    }

    public function AgregarImpuestos($impuesto){
        $this->_precio += $impuesto;
    }

    public static function MostrarAuto($auto){
        echo $auto;
    }

    public function Equals($a1, $a2){
        if($a1->_marca == $a2->_marca){
            return true;
        }
        
        return false;
    }

    public function Add($autoUno, $autoDos){
        if($autoUno->Equals($autoUno, $autoDos) && $autoUno->_color == $autoDos->_color){
            return $autoUno->_precio + $autoDos->_precio;
        }

        return 0;
    }
}
?>