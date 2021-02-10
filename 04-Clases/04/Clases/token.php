<?php

require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;

class Token
{
    /**
     * Genera algoritmo codificado Token a partir del payload y clave
     * Return JWT token encriptado
     */
    function GenerarToken($key)
    {
        $payload = array(
            "email" => "agusszurdob@gmail.com",
            "clave" => "1234",
        );
        return JWT::encode($payload, $key); 
    }

    /**
     * Obtiene algoritmo codificado Token a partir del token y clave
     * Return JWT token encriptado o NULL en su defecto
     */
    function ObtenerToken($token, $key)
    {
        try{
            //$token = $_SERVER["HTTP_TOKEN"];
            return JWT::decode($token, $key, array('HS256'));
        }
        catch(\Throwable $th){
            return null;
        }
    }
}





?>