    <?php

use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;
use Config\Database;
use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddlewareAdmin;
use App\Middlewares\AuthMiddlewareCliente;
use App\Middlewares\AuthMiddlewareProfesor;
use App\Middlewares\AuthMiddlewareVarios;
use App\Controllers\UsuarioController;
use App\Controllers\MascotaController;
use App\Controllers\ClienteMascotaController;
use App\Modelos\Cliente;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('parcial/public'); 
new Database;
$app->add(new JsonMiddleware);

//Punto 1
$app->post('/users',UsuarioController::class.":addOne");

//Punto 2
$app->post('/login',UsuarioController::class.":loginUsuario");

//Punto 3
$app->group('/mascota',function(RouteCollectorProxy $group){
    $group->post('[/]',MascotaController::class.":addOne")->add(new AuthMiddlewareAdmin);
});

//Punto 4 y 6
$app->group('/turno',function(RouteCollectorProxy $group){
    //Punto 4
    $group->post('[/]',MascotaController::class.":turno")->add(new AuthMiddlewareCliente);
    //Punto 6
    $group->put('/{idTurno}',ClienteMascotaController::class.":aisgnarEstado")->add(new AuthMiddlewareAdmin);
});

//Punto 5
$app->group('/turnos',function(RouteCollectorProxy $group){
    $group->get('[/]',ClienteMascotaController::class.":verTodas")->add(new AuthMiddlewareAdmin);
});

//Punto 7
$app->get('[/]',ClienteMascotaController::class.":verFacturas")->add(new AuthMiddlewareCliente);

$app->addBodyParsingMiddleware();
$app->run();