<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;

class Usuario{

    //Fields
    public $_email;
    public $_clave;
    public $_foto;

    //Construct
    function __construct($email, $clave, $foto = null)
    {
        $this->_email = $email;
        $this->_clave = $clave;
        $this->_foto = $foto != null ? $foto : "";
    }

    //Method of Instance: retornará los datos del objeto (en una cadena con formato JSON).
    public function ToJson()
    {
        $flag = new stdClass();
        if($this != null)
        {
            $flag->email = $this->_email;
            $flag->clave = $this->SetClaveToJWT();
            $flag->foto = $this->_foto;
        }
        return json_encode($flag);
    }
    
    //Method of Instance: retornará los datos del objeto (en una cadena con formato JWT).
    public function ToJWT($key = "pro3-parcial")
    {
        $payload = array(
            "email" => $this->_email,
            "clave" => $this->_clave,
            "foto" => $this->_foto
        );
        return JWT::encode($payload, $key); 
    }

    //Magic Method: retornará los datos del objeto (string).
    public function __ToString()
    {
        $str = "Inexistente";
        if($this != null)
        {
            $str = "EMAIL: " . $this->_email . "<br>";
            $str .= "CLAVE: " . $this->_clave . "<br>";
            $str .= "FOTO: " . $this->_foto . "<br><br>";
        }
        return $str;
    }
    
    //Method of Class: get object kind Usuario if exists by it token
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
     * $path por defecto = "./archivos/users.json"
     * Return bool: True if save, False if not
     */
    public function SaveAsFile($path = "./archivos/users.json") : bool
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

    //Method of Class: obtiene todos los objetos de tipo Usuario en formato json dentro de un array
    public static function GetAll()
    {
        $retornoArray = array();
        $path = "./archivos/users.json";

        if(file_exists($path)) { //si existe
            $ar = fopen($path, "r"); //abro archivo
            if($ar != false) {
                while(!feof($ar)) {
                    $linea = trim(fgets($ar)); //obtiene la linea sin espacios
                    if($linea != "") //si llegamos a la linea vacia
                    { 
                        $auxJWT = json_decode($linea); //convierte la linea en un jwt para que lo lea y sea guardable en ufolo
                        $obj = new Usuario($auxJWT->email, $auxJWT->clave, $auxJWT->foto);
                        array_push($retornoArray, $obj); //agrega el objeto leido al array 
                    }
                }
                fclose($ar); //cierro el archivo
            }
        }
        return $retornoArray;
    }
    
    //Method of Instance: set field (_clave) of instance by a JWT token
    public function SetClaveToJWT($keyJWT = "pro3-parcial")
    {
        $payload = array(
            "clave" => $this->_clave,
        );
        return JWT::encode($payload, $keyJWT); 
    }

    /**
     * Method of Instance: return an string with data of an obj Profesor
     * Param: $legajo = unic identity of an obj Profesor
     * Return: obj Usuario or NULL pointer
     */
    public function GetUser()
    {
        $email = $this->_email;
        $claveJWT = $this->SetClaveToJWT();
        $arrayObj = Usuario::GetAll();
        
        foreach($arrayObj as $aux){
            if($aux->_email == $email && $aux->_clave == $claveJWT){
                return $aux;
            } 
        }
    }

    /**
     * Method of Instance: check if field of instance _email is okey
     * Return bool: True if fields are okey - False if not
     */
    public function CheckEmail()
    {
        $email = $this->_email;

        if($email != "" && strlen($email) > 8){
            $arrayObj = Usuario::GetAll();

            foreach($arrayObj as $aux){
                if($aux->_email == $email){
                    return false;
                } 
            }
        }
        return true;
    }

    /**
     * Method of Instance: check if field of instance _pass is okey
     * Return bool: True if fields are okey - False if not
     */
    public function CheckPass()
    {
        $pass = $this->_clave;
        
        if(strlen($pass) > 8 && strlen($pass) < 15){
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
            return $this->CheckEmail() && $this->CheckPass();
        }
        return false;
    }

    /**
     * Method of Instance: set name of field _foto in case of existent
     * Return void
     */
    public function SetNamePhoto()
    {
        if($this->_foto != ""){
            $name = explode(".", $this->_foto);
            $extension = pathinfo($this->_foto, PATHINFO_EXTENSION);
            $this->_foto = $name[0]. "_" . date("Gis") . "." . $extension;
        }
    }

    /**
     * Method of Class: move a file
     * Return void
     */
    public static function MovePhoto($origen, $destino)
    {
        return move_uploaded_file($origen, $destino);
    }
}
?>