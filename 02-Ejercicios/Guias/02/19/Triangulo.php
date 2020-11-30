<?php

require_once "FiguraGeometrica.php";

class Triangulo extends FiguraGeometrica {

    #atributos
    private $_base;
    private $_altura;

    #constructor
    public function __construct($b, $h){
        $this->_altura = $h;
        $this->_base = $b;
    }

    #metodos
    protected function CalcularDatos(){
        $this->_perimetro = ($this->_base * 3);
        $this->_superficie = ($this->_base * $this->_altura);
    }

    public function Dibujar(){
        $espacios=($this->_base)/2;
        $lunares=($this->_base)-($this->_altura)+1;
        $dibu ='<div style="color : green">';
        for($i=0; $i<$this->_altura; $i++)
        {
            for($k=0; $k<$espacios; $k++)
            {
                $dibu .= "&nbsp;";                    
            }  
            for($j=0; $j<$lunares; $j++)
            {
                $dibu .= "*";
            }
            $dibu .= "<br>";
            $espacios--;
            $lunares++;
        }
        echo $dibu . "</div>";
    }

    public function ToString()
    {
        return parent::ToString(). "<br>Altura:". $this->_altura. "<br>Base: ". $this->_base;
    }
}
?>