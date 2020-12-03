<?php
namespace App\Controllers;

use App\Modelos\Cliente_Mascota;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ClienteMascotaController
{
    public function asignarNota(Request $request,Response $response,$args)
    {
        $idCliente = $request->getParsedBody()['idCliente'];
        $idMascota = $args['idMascota'];
        $respuesta = $idCliente;

        $response->getBody()->write(json_encode($respuesta));
    }

    public function verTodas(Request $request,Response $response)
    {
        $respuesta = Cliente_Mascota::
        join('clientes', 'clientes.id', '=', 'clientes_mascotas.id_mascota')
        ->select('clientes_mascotas.id_cliente as Cliente', 'clientes.nombre','mascotas.tipo', 'mascotas.fecha', 'mascotas.precio')
        ->get();            
        $response->getBody()->write(json_encode($respuesta));
        
        return $response;
    }

    public function verTurnosMascota(Request $request, Response $response, $args)
    {
        $idMascota = $args['idMascota'];
        $respuesta = Cliente_Mascota::
        join('mascotas','mascotas.id', '=','clientes_mascotas.id_mascota')
        ->select('clientes_mascotas.nota as Turnos de la Mascota','clientes_mascotas.id_mascota as Mascota','mascotas.mascota as Mascota')
        ->where('clientes_mascotas.id_mascota','=',$idMascota)
        ->get();       
        $response->getBody()->write(json_encode($respuesta));
        
        return $response;
    }

    //Punto 6
    public function asignarEstado(Request $request,Response $response,$args)
    {
        $parsedBody = $request->getParsedBody();
        $idTurno = $args["idTurno"];

        $turno = Turno::find($args["idTurno"]);

        if($turno == null) {
            $response->getBody()->write(json_encode("No existe un turno de id: $idTurno"));
        }
        else {
            $turno = Turno::find($idTurno);
                    
            $turno->atendido = "OK";
            $turno->save();
                
            $response->getBody()->write(json_encode("Asignacion de atendido exitosa"));
        }

        return $response;
    }  

    public function verFacturas(Request $request, Response $response, $args)
    {
        $token = $request->getHeaderLine('token');
        $idCliente = UsuarioController::ObtenerIdToken($token);
        $respuesta = Cliente_Mascota::

        join('mascotas','mascotas.id', '=','clientes_mascotas.id_mascota')
        ->select('clientes_mascotas.nota as Turnos de la Mascota','clientes_mascotas.id_mascota as Mascota','mascotas.mascota as Mascota')
        ->where('clientes_mascotas.id_cliente','=',$idCliente)
        ->get();       
        $response->getBody()->write(json_encode($respuesta));
        
        return $response;
    }
}