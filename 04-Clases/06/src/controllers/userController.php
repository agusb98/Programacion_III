<?php
namespace App\Controllers;
use App\Models\User;

class UserController{
    public function getAll($request, $response, $args) {
        $rta = User::where('id', '>',  0)
        ->get();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getOne($request, $response, $args) {
        if($user = User:: find($args["id"])){
            $response->getBody()->write(json_encode($user));
        }
        else{ $response->getBody()->write("Usuario no encontrado"); }
        return $response;
    }

    public function add($request, $response, $args) {
        $user = new User;
        $user->nombre = "Juan";
        $user->apellido = "Hosto";
        $user->edad = "54";

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function update($request, $response, $args) {
        if($user = User:: find($args["id"])){
            $user->nombre = "Juancito";
            $rta = $user->save();
            $response->getBody()->write(json_encode($rta));
        }
        else{ $response->getBody()->write("Usuario no encontrado"); }
        return $response;
    }

    public function delete($request, $response, $args) {
        if($user = User:: find($args["id"])){
            $rta = $user->delete();
            $response->getBody()->write(json_encode($rta));
        }
        else{ $response->getBody()->write("Usuario no encontrado"); }
        return $response;
    }
}

?>