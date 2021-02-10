<?php
//COMPOSER - MANEJADOR DE ARCHIVOS

//En la terminal, "composer init" y crea archivo "composer.json"
//Con ese archivo, podre manejar las dependencias
//En la terminal, "composer require firebase/php-jwt" y creara "vendor" y "composer.lock"

//Nunca subire vendor en github, para lo cual creare el archivo ".gitignore"

//Link firebase/php-jwt: https://github.com/firebase/php-jwt

//En la terminal, " composer dump-autoload -o "
//En la terminal, " composer require slim/slim:"4.*" "
//En la terminal, " composer require slim/psr7 "
//En la terminal, " composer require illuminate/database "
//En la terminal, " composer require illuminate/events "

//Link: https://www.slimframework.com/docs/v4/

///////////////////////////////////////////////////////////////////////////

use \Firebase\JWT\JWT;
use Clases\Usuario;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteCollectorProxy;
use Slim\Middleware\ErrorMiddleware;

use App\Controllers\UserController;
use Config\Database;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/04-Clases/06"); //IMPORTANTE la ruta donde se encuentra el index.php
new Database;
//$app->addRoutingMiddleware();

$app->group('/users', function (RouteCollectorProxy $group)
{
    $group->get('/{id}', UserController::class . ":getOne");
    $group->get('[/]', UserController::class . ":getAll");
    $group->post('[/]', UserController::class . ":add");
    $group->put('/{id}', UserController::class . ":update");
    $group->delete('/{id}', UserController::class . ":delete");
});

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->run();