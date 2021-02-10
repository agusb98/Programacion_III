<?php
class Post
{
    public function Guardar($archivo) : bool
    {
        $patente = $_POST['patente'] ?? "";
        $marca = $_POST['marca'] ?? "";
        $color = $_POST['color'] ?? "";
        $precio = $_POST['precio'] ?? 0;
        
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
        $patente = $_POST['patente'] ?? "";
        $marca = $_POST['marca'] ?? "";
        $color = $_POST['color'] ?? "";
        $precio = $_POST['precio'] ?? 0;
        
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
        $patente = $_POST['patente'] ?? "";
        $list = Archivos::Deserealizacion($archivo);
        $auto = Auto::BuscarPorPatente($patente, $list);

        if($auto != NULL){
            echo $auto;
        }
        else{
            echo"Auto no Encontrado";
        }
    }

    public function BuscarEnJson($archivo)
    {
        $patente = $_POST['patente'] ?? "";
        $list = Archivos::GetAsJson($archivo);
        $auto = Auto::BuscarPorPatente($patente, $list);

        if($auto != NULL){
            var_dump(MostrarAuto($auto));
        } 
    }
}
?>