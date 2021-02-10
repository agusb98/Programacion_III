<?php

require __DIR__ . '/../vendor/autoload.php';

use clases\usuario;
//use Config\Database;
//use App\Controllers\UserController;

use \Firebase\JWT\JWT;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;
use Slim\Middleware\ErrorMiddleware;

$app = AppFactory::create();
$app->setBasePath("/04-Clases/07/public/");

$app->get('[/]', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello GET!");
    return $response;
});

/*
$app->group('/users', function (RouteCollectorProxy $group) {
    
    $group->get('/{id}', UserController::class . ":getOne");

    $group->get('[/]', UserController::class . ":getAll");

    $group->post('[/]', UserController::class . ":add");
    
    $group->put('/{id}', UserController::class . ":update");

    $group->delete('/{id}', UserController::class . ":delete");
});*/

$app->run();