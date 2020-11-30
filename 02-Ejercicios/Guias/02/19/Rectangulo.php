<?php

require_once "FiguraGeometrica.php";

class Rectangulo extends FiguraGeometrica {

    #atributos
    private $_l1;
    private $_l2;

    #constructor
    public function __construct($l1, $l2){
        $this->_l1 = $l1;
        $this->_l2 = $l2;
    }

    #metodos
    protected function CalcularDatos(){
        $this->_perimetro = ($this->_l1 * 2) + ($this->_l2 * 2);
        $this->_superficie = ($this->_l1 * $this->_l2);
    }

    public function Dibujar(){
        $espacios=($this->_l1)/2;
        $lunares=($this->_l1)-($this->_l2)+1;
        $dibu ='<div style="color : green">';
        for($i=0; $i<$this->_l2; $i++)
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
        return parent::ToString(). "<br>Lado Uno:". $this->_l1. "<br>Lado Dos: ". $this->_l2;
    } 
}
?>