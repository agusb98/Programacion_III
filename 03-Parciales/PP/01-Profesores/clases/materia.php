<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;

class Materia
{
	//Fields: id, nombre y cuatrimestre
    public $_id;
	public $_nombre;
    public $_cuatrimestre;
	
	//Construct
	public function __construct($nombre, $cuatrimestre, $id = null)
	{
        $this->_id = $id != null ? $id : date("Gis");
		$this->_nombre = $nombre;
        $this->_cuatrimestre = $cuatrimestre;
	}

    //Method of Instance: retornará los datos del objeto (en una cadena con formato JSON).
	public function ToJson()
    {
        $flag = new stdClass();
        if($this != null)
        {
            $flag->id = $this->_id;   //Seteo id a uno unico
            $flag->nombre = $this->_nombre;
			$flag->cuatrimestre = $this->_cuatrimestre;
			
        }
        return json_encode($flag);
    }

    //Method of Instance: retornará los datos del objeto (en una cadena con formato JWT).
    public function ToJWT($key = "pro3-parcial")
    {
        $payload = array(
            "id" => $this->_id,   //Seteo id a uno unico
            "nombre" => $this->_nombre,
            "cuatrimestre" => $this->_cuatrimestre
        );
        return JWT::encode($payload, $key); 
    }

    //Magic Method: retornará los datos del objeto (string).
    public function __ToString()
    {
        $str = "Inexistente";
        if($this != null)
        {
            $str = "ID: " . $this->_id . "<br>";
            $str .= "NOMBRE: " . $this->_nombre . "<br>";
            $str .= "CUATRIMESTRE: " . $this->_cuatrimestre . "<br><br>";
        }
        return $str;
    }

    //Method of Class: get object kind Materia if exists by it token
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
     * Method of Instance: save instance in path passed by param
     * $path by defec = "./archivos/materias.json"
     * Return bool: True if save, False if not
     */
	public function SaveAsFile($path = "./archivos/materias.json")
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
        $path = "./archivos/materias.json";

        if(file_exists($path)) { //si existe
            $ar = fopen($path, "r"); //abro archivo
            if($ar != false) {
                while(!feof($ar)) {
                    $linea = trim(fgets($ar)); //obtiene la linea sin espacios
                    if($linea != "") //si llegamos a la linea vacia
                    { 
                        $auxJWT = json_decode($linea); //convierte la linea en un json para que lo lea y sea guardable en ufolo
                        $auxObj = new Materia($auxJWT->nombre, $auxJWT->cuatrimestre, $auxJWT->id);
                        array_push($retornoArray, $auxObj); //agrega el objeto leido al array
                    }
                }
                fclose($ar); //cierro el archivo
            }
        }
        return $retornoArray;
    }
    
    /**
     * Method of Class: return an obj Materia
     * Param: $id = unic identity of an obj Materia
     * Return: obj Materia or NULL pointer
     */
    public static function GetById($id)
    {
        foreach(Materia::GetAll() as $obj){
            if($obj->_id == $id){
                return $obj;
            }
        }
    }

    /**
     * Method of Instance: check if field of instance _name is okey
     * Return bool: True if fields are okey - False if not
     */
    public function CheckName()
    {
        $nombre = $this->_nombre;
        if(strlen($nombre) > 0){
            return true;
        }
        return false;
    }

    /**
     * Method of Instance: check if field of instance _name is okey
     * Return bool: True if fields are okey - False if not
     */
    public function CheckCuatrimestre()
    {
        $cuatrimestre = $this->_cuatrimestre;
        if(strlen($cuatrimestre) > 0){
            return true;
        }
        return false;
    }

    /**
     * Method of Instance: check if fields of instance are okey
     * Return bool: True if fields are okey - False if not
     */
    public function Validation()
    {
        if($this != null){
            return $this->CheckName() && $this->CheckCuatrimestre();
        }
        return false;
    }
}