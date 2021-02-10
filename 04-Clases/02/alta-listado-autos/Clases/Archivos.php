<?php

/**
 * MANEJOS DE ARCHIVOS
 * 
 * Serializacion: Escribe en el Archivo, el path es su ruta
 * Deserializacion: Lee del Archivo, el path es su ruta
 * Json
 */

     /////////////////////////////////////////////

    /*  Archivos

    fopen()
    fclose()

    fread() y fgets()
    fwrite() y fputs()

    fcopy()

    fopen()
    r -> abre solo lectura
    w -> abre solo escritura. si no existe lo crea. si existe lo sobreescribe
    a -> abre solo escritura. si no existe lo crea de nuevo. si existe escribe al final
    x -> crea un archivo solo lectura. devuelve false si ya existe
    r+ -> ??????????????

    fclose()

    fread()
    devuelve un string con todo el contenido
    arg1 -> archivo
    arg2 -> tamaño a leer

    fgets()
    devuelve un string con una sola linea
    arg1 -> archivo a ser leido
    mueve el cursor a la línea siguiente

    fwrite()
    arg1 -> archivo
    arg2 -> string a escribir
    devuelve cantidad de bytes escritos

    copy()
    arg1 -> from
    arg2 -> to

    $archivo = fopen("archivo.txt", "a+");

    // Leo entero
    //echo fread($archivo, filesize("archivo.txt"));

    // Leo línea por línea
    while (!feof($archivo)) {
        echo fgets($archivo) . "<br>";
    }

    $byes = fwrite($archivo, "\nLínea escrita");

    copy("archivo.txt", "archivo2.txt");
    unlink("archivo2.txt");

    $cerrar = fclose($archivo);

    */
    class Archivos
    {
        static function Deserealizacion($path)
        {
            $list = array();
            $archivo = fopen("./" . $path, "a+");

            while(!feof($archivo))
            {
                $obj = unserialize(fgets($archivo)); //deserializa el objeto

                if($obj != NULL){
                    array_push($list, $obj);
                }
            }

            fclose($archivo);
            return $list;
        }

        static function Serializacion($path, $obj)
        {
            $b = true; //Bandera indicando si existe otro auto con mismos datos en Archivo
            $prevList = Archivos::Deserealizacion($path);

            foreach($prevList as $obj2){
                if(Auto::Equals($obj, $obj2))
                {
                    //Verifico que no se repitan los datos
                    $b = false;
                    break;
                }
            }
            
            if($b){
                $archivo = fopen("./" . $path, "a+");

                //serializa el objeto
                fwrite($archivo, serialize($obj). PHP_EOL);  //PHP_EOL es para el salto de linea
                fclose($archivo);
            }
        }

        /**
         * Guarda en un archivo JSON
         * dato importante: los atributos de la clase DEBEN ser publicos
         */
        static function SaveAsJson($path, $obj)
        {
            $b = true; //Bandera indicando si existe otro auto con mismos datos en Archivo
            $prevList = Archivos::GetAsJson($path);

            foreach($prevList as $obj2){
                if(Auto::Equals($obj, $obj2))
                {
                    //Verifico que no se repitan los datos
                    $b = false;
                    break;
                }
            }

            if($b){
                $archivo = fopen("./" . $path, "w");
                array_push($prevList, $obj);
    
                fwrite($archivo, json_encode($prevList));
                fclose($archivo);
            }
        }

        /**
         * Obtiene lista de obj tipo Auto desde un archivo JSON
         */
        static function GetAsJson($path)
        {
            $archivo = fopen($path, "a+");
            $list = json_decode(fgets($archivo));

            if($list != NULL){
                fclose($archivo);
                return $list;
            }
            
            fclose($archivo);
            return array();
        }
    }
?>