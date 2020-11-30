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

use \Firebase\JWT\JWT;
use Clases\Usuario;

//Link: https://www.slimframework.com/docs/v4/

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/04-Clases/06"); //IMPORTANTE la ruta donde se encunetra el index.php

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello Get!");
    return $response;
});

$app->post('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello POST!");
    return $response;
});

$app->run();