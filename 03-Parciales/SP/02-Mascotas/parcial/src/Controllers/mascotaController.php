<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Modelos\Mascota;
use App\Modelos\Cliente_Mascota;
use App\Modelos\Usuario;

class MascotaController
{
    //Punto 3
    public function addOne(Request $request, Response $response) 
    {
        $respuesta = "Se ha producido un error al guardar o el permiso es invalido";        
        $nuevaMascota = new Mascota;        
        $nuevaMascota->id = getNewId();
        $nuevaMascota->tipo = $request->getParsedBody()['tipo'];
        $nuevaMascota->precio = $request->getParsedBody()['precio'];

        if($nuevaMascota->save()) {
            $respuesta = "Mascota guardada en la base de datos correctamente!";
        }        
        $response->getBody()->write(json_encode($respuesta));

        return $response;
    }
    
    //Punto 4
    public function turno(Request $request, Response $response, $args)
    {        
        $respuesta = "Se ha producido un error al inscribir o el cliente es incorrecto";
        $idCliente = UsuarioController::ObtenerLegajoToken($request->getHeaderLine('token'));
        $tipo = $args['tipo'];
        $fecha = $args['fecha'];
        $nuevoTurno = new Cliente_Mascota;

        if($idCliente) {            
            $nuevoTurno->id_cliente = $idCliente;
            $nuevoTurno->tipo = $tipo;
            $nuevoTurno->fecha = $fecha;
            $nuevoTurno->save();            
            $respuesta = "La turno se ha realizado correctamente!";
        }        
        $response->getBody()->write(json_encode($respuesta));

        return $response;
    }

    public function traerMascotas($tipo) {
        $listaMascotas = Mascota::get();

        foreach ($listaMascotas as $mascota)  {
            if($tipo == $mascota->tipo) {
                $mascota->save();
                return true;
            }
        }
        return false;
    }

    public function getNewId() {
        $listaMascotas = Mascota::get();
        $id = 0;

        foreach ($listaMascotas as $mascota)  {
            $id = $mascota->id + 1;
        }
        return $id;
    }

    //Punto 7
    public function verTodas(Request $request, Response $response)
    {
        $respuesta = Mascota::get();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }
}