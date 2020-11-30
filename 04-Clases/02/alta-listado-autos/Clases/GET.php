<?php
class Get
{
    public function Guardar($archivo) : bool
    {
        $patente = $_GET['patente'] ?? "";
        $marca = $_GET['marca'] ?? "";
        $color = $_GET['color'] ?? "";
        $precio = $_GET['precio'] ?? 0;
        
        if(Auto::ValidarAuto($patente, $marca, $color, $precio))
        {
            $auto = new Auto($patente, $marca, $color, $precio);
                        
            $auto->AgregarImpuestos($precio * 0.21);
            Archivos::Serializacion($archivo, $auto);
            
            return true;
        } 
        return false;
    }

    public function GuardarEnJson($archivo) : bool
    {
        $patente = $_GET['patente'] ?? "";
        $marca = $_GET['marca'] ?? "";
        $color = $_GET['color'] ?? "";
        $precio = $_GET['precio'] ?? 0;
        
        if(Auto::ValidarAuto($patente, $marca, $color, $precio))
        {
            $auto = new Auto($patente, $marca, $color, $precio);
                        
            $auto->AgregarImpuestos($precio * 0.21);
            Archivos::SaveAsJson($archivo, $auto);

            return true;
        }
        else{
            echo "Error en el Ingreso de Datos";
            return false;
        } 
    }

    public function BuscarPorPatente($archivo)
    {
        $patente = $_GET['patente'] ?? "";
        $list = Archivos::Deserealizacion($archivo);
        echo Auto::BuscarPorPatente($patente, $list);
    }

    public function BuscarEnJson($archivo)
    {
        $patente = $_GET['patente'] ?? "";
        $list = Archivos::GetAsJson($archivo);
        $auto = Auto::BuscarPorPatente($patente, $list);

        if($auto != NULL){
            var_dump($auto);
        } 
    }
}
?>