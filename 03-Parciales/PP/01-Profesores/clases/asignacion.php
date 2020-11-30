<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;

class Asignacion{

    //Fields: email, clave y foto
    public $_legajoProfesor;
    public $_idMateria; 
    public $_turno;

    //Construct
    function __construct($legajoProfesor, $idMateria, $turno)
    {
        $this->_legajoProfesor = $legajoProfesor;
        $this->_idMateria = $idMateria;
        $this->_turno = $turno;
    }
    
    //Method of Instance: retornará los datos del objeto (en una cadena con formato JSON).
    public function ToJson()
    {
        $flag = new stdClass();
        if($this != null)
        {
            $flag->legajoProfesor = $this->_legajoProfesor;
            $flag->idMateria = $this->_idMateria;
            $flag->turno = $this->_turno;
        }
        return json_encode($flag);
    }

    //Method of Instance: retornará los datos del objeto (en una cadena con formato JWT).
    public function ToJWT($key = "pro3-parcial")
    {
        $payload = array(
            "legajoProfesor" => $this->_legajoProfesor,   
            "idMateria" => $this->_idMateria,
            "turno" => $this->_turno,
        );
        return JWT::encode($payload, $key); 
    }
        
    //Magic Method: retornará los datos del objeto (string).
    public function __ToString()
    {
        $str = "Inexistente";
        if($this != null)
        {
            $str = "PROFESOR: " . $this->_legajoProfesor . "<br>";
            $str .= "MATERIA: " . $this->_idMateria . "<br>";
            $str .= "TURNO: " . $this->_turno . "<br><br>";
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
     * $path por defecto = "./archivos/materias-profesores.json"
     * Return bool: True if save, False if not
     */
    public function SaveAsFile($path = "./archivos/materias-profesores.json")
    {
        $flag = false;
        $ar = fopen($path,"a"); //abro archivo

        if($ar != false) 
        {
            if(fwrite($ar, $this->ToJson()."\r\n")) { //escribo este objeto por medio del metodo ToJWT 
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
        $path = "./archivos/materias-profesores.json";

        if(file_exists($path)) { //si existe
            $ar = fopen($path, "r"); //abro archivo
            if($ar != false) {
                while(!feof($ar)) {
                    $linea = trim(fgets($ar)); //obtiene la linea sin espacios
                    if($linea != "") //si llegamos a la linea vacia
                    { 
                        $auxJWT = json_decode($linea); //convierte la linea en un json para que lo lea y sea guardable en Objeto
                        $auxObj = new Asignacion($auxJWT->legajoProfesor, $auxJWT->idMateria, $auxJWT->turno);
                        array_push($retornoArray, $auxObj); //agrega el objeto leido al array
                    }
                }
                fclose($ar); //cierro el archivo
            }
        }
        return $retornoArray;
    }

    /**
     * Method of Instance: check if fields of instance are okey
     * Return bool: True if fields are okey - False if not
     */
    public function CheckTurnoProfesor()
    {
        $legajo = $this->_legajoProfesor;
        $idMateria = $this->_idMateria;
        $turno = $this->_turno;

        foreach(Asignacion::GetAll() as $aux)
        {
            if($aux->_turno == $turno && $aux->_legajoProfesor == $legajo){
                return false;
            }
            else if($aux->_idMateria == $idMateria && $aux->_legajoProfesor == $legajo){
                return false;
            } 
        }
        return true;
    }

    /**
     * Method of Instance: check if field of instance (_turno) is okey
     * Return bool: True if field is okey - False if not
     */
    public function CheckTurno()
    {
        $turno = $this->_turno;
        if($turno != ""){
            return true;
        }
        return false;
    }

    /**
     * Method of Instance: check if field of instance (_idMateriaurno) is okey
     * Return bool: True if field is okey - False if not
     */
    public function CheckIdMateria()
    {
        $id = $this->_idMateria;

        if($id > 0)
        {
            foreach(Materia::GetAll() as $aux){
                if($aux->_id == $id){
                    return true;
                } 
            }
        }
        return false;
    }

    /**
     * Method of Instance: check if field of instance (_legajoProfesor) is okey
     * Return bool: True if field is okey - False if not
     */
    public function CheckLegajoProfesor()
    {
        $legajo = $this->_legajoProfesor;

        if($legajo > 0){

            $arrayObj = Profesor::GetAll();

            foreach($arrayObj as $obj){
                if($obj->_legajo == $legajo){
                    return true;
                } 
            }
        }
        return false;
    }

    /**
     * Method of Instance: check if fields of instance are okey
     * Return bool: True if field is okey - False if not
     */
    public function Validation()
    {
        if($this->CheckLegajoProfesor()){
            if($this->CheckIdMateria()){
                if($this->CheckTurno()){
                    if($this->CheckTurnoProfesor()){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Method of Instance: get string with all Materias for Profesor
     * Return string with data
     */
    public static function MateriasPorProfesor()
    {
        $arrayAsig = Asignacion::GetAll();
        $arrayProf = Profesor::GetAll();
        $arrayMat = Materia::GetAll();
        $str = "Profesor - Materia <br>";

        foreach($arrayAsig as $asig){
            foreach($arrayProf as $prof){
                if($asig->_legajoProfesor == $prof->_legajo){
                    $str .= "<br>" . $prof->ToJson() . ": ";
                    foreach($arrayMat as $mat){
                        if($asig->_idMateria == $mat->_id){
                            $str .= $mat->ToJson() . ", ";     
                        }
                    }
                }
            }
        }
        return $str;
    }
}
?>