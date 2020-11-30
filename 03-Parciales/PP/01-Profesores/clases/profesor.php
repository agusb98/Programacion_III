<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;

class Profesor{

    //Fields
    public $_nombre;
    public $_legajo;

    //Construct
    function __construct($nombre, $legajo)
    {
        $this->_nombre = $nombre;
        $this->_legajo = $legajo;
    }
    
    //Method of Instance: retornará los datos del objeto (en una cadena con formato JSON)..
    public function ToJson()
    {
        $flag = new stdClass();
        if($this != null)
        {
            $flag->nombre = $this->_nombre;
            $flag->legajo = $this->_legajo;
        }
        return json_encode($flag);
    }

    //Method of Instance: retornará los datos del objeto (en una cadena con formato JWT).
    public function ToJWT($key = "pro3-parcial")
    {
        $payload = array(
            "nombre" => $this->_nombre,   
            "legajo" => $this->_legajo,
        );
        return JWT::encode($payload, $key); 
    }

    //Magic Method: retornará los datos del objeto (string).
    public function __ToString()
    {
        $str = "Inexistente";
        if($this != null)
        {
            $str = "NOMBRE: " . $this->_nombre . "<br>";
            $str .= "LEGAJO: " . $this->_legajo . "<br><br>";
        }
        return $str;
    }

    //Method of Class: get object kind Asignacion if exists by it token
    public static function JwtDecode($token, $key = "pro3-parcial")
    {
        try{
            return JWT::decode($token, $key, array('HS256'));
        }
        catch(\Throwable $th){
            return null;
        }
    }
    
    /**
     * Method of Instance: guarda instancia en ruta pasado por parametro
     * $path por defecto = "./archivos/profesores.json"
     * Return bool: True if save, False if not
     */
    public function SaveAsFile($path = "./archivos/profesores.json")
    {
        $flag = false;
        $ar = fopen($path,"a"); //abro archivo

        if($ar != false) 
        {
            if(fwrite($ar, $this->ToJson()."\r\n")) { //escribo este objeto por medio del metodo ToJson 
                $flag = true;
            }
            fclose($ar);    //cierro archivo
        }

        return $flag;
    }

    //Method of Class: obtiene todos los objetos de tipo Materia en formato json dentro de un array
    public static function GetAll()
    {
        $retornoArray = array();
        $path = "./archivos/profesores.json";

        if(file_exists($path)) { //si existe
            $ar = fopen($path, "r"); //abro archivo
            if($ar != false) {
                while(!feof($ar)) {
                    $linea = trim(fgets($ar)); //obtiene la linea sin espacios
                    if($linea != "") //si llegamos a la linea vacia
                    { 
                        $auxJWT = json_decode($linea); //convierte la linea en un jwt para que lo lea y sea guardable en ufolo
                        $obj = new Profesor($auxJWT->nombre, $auxJWT->legajo);
                        array_push($retornoArray, $obj); //agrega el objeto leido al array 
                    }
                }
                fclose($ar); //cierro el archivo
            }
        }
        return $retornoArray;
    }
    
    /**
     * Method of Class: return an obj Profesor
     * Param: $legajo = unic identity of an obj Profesor
     * Return: obj Profesor or NULL pointer
     */
    public static function GetByLegajo($legajo)
    {
        foreach(Profesor::GetAll() as $obj){
            if($obj->_legajo == $legajo){
                return $obj;
            }
        }
    }

    /**
     * Method of Instance: check if field of instance _nombre is okey
     * Return bool: True if fields are okey - False if not
     */
    public function CheckName()
    {
        $nombre = $this->_nombre;
        if($nombre == ""){
            return false;
        }
        return true;
    }

    /**
     * Method of Instance: check if field of instance _legajo is okey
     * Return bool: True if fields are okey - False if not
     */
    public function CheckLegajo()
    {
        $legajo = $this->_legajo;
        $flag = false;

        if($legajo > 0)
        {
            $arrayObj = Profesor::GetAll();
            foreach($arrayObj as $aux){
                if($aux->_legajo == $legajo){
                    return false;
                } 
            }
            $flag = true;
        }
        return $flag;
    }

    /**
     * Method of Instance: check if fields of instance are okey
     * Return bool: True if fields are okey - False if not
     */
    public function Validation()
    {
        return $this->CheckName() && $this->CheckLegajo();
    }
}
?>