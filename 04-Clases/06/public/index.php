<?php
//COMPOSER - MANEJADOR DE ARCHIVOS

//En la terminal, "composer init" y crea archivo "composer.json"
//Con ese archivo, podre manejar las dependencias
//En la terminal, "composer require firebase/php-jwt" y creara "vendor" y "composer.lock"

//Nunca subire vendor en github, para lo cual creare el archivo ".gitignore"

//Link firebase/php-jwt: https://github.com/firebase/php-jwt

//En la terminal, " composer require slim/slim:"4.*" "
//En la terminal, " composer require slim/psr7 "
//En la terminal, " composer dump-autoload -o "

require __DIR__ . '/vendor/autoload.php';

use \Firebase\JWT\JWT;
use Clases\Usuario;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;
use Slim\Middleware\ErrorMiddleware;

use App\Controllers\UserController;
use Config\Database;


$app = AppFactory::create();
$app->setBasePath("/04-Clases/06");
new Database;

$app->group('/users', function (RouteCollectorProxy $group) {
    
    $group->get('/{id}', UserController::class . ":getOne");

    $group->get('[/]', UserController::class . ":getAll");

    $group->post('[/]', UserController::class . ":add");
    
    $group->put('/{id}', UserController::class . ":update");

    $group->delete('/{id}', UserController::class . ":delete");
});

// $app->get('/', function ($request, $response, $args) {
//     $response->getBody()->write("Hello GET!");
//     return $response;
// });

// $app->get('/usuarios/{id}', function ($request, $response, $args) {
//     // $newResponse = $response->withStatus(302);
//     $data = array('name' => 'Bob', 'age' => 40);
//     $payload = json_encode($args);


//     $response->getBody()->write($payload);
//     return $response
//     ->withHeader('Content-Type', 'application/json');
//     // $newResponse = $response->withHeader('Content-type', 'application/json');
//     // $newResponse->getBody()->write("Hello usuarios!");
//     // return $newResponse;
// });



$app->post('/usuarios', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello POST!");

    return $response;
});

// $app->any('/.+', function ($request, $response, $args) {
//     $response->getBody()->write("Hello GET!");
//     return $response;
// });
// $app->any('/[{name}][/]', function (Request $request, Response $response, array $args) {
//     // Apply changes to books or book identified by $args['id'] if specified.
//     // To check which method is used: $request->getMethod();
//     $response->getBody()->write("Hello POST USERS!");
//     return $response;
// });
// $errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();


// $jwt = new \Clases\JWT();
// $key = "example_key";
// $payload = array(
//     "iss" => "http://example.org",
//     "aud" => "http://example.com",
//     "iat" => 1356999524,
//     "nbf" => 1357000000
// );

// /**
//  * IMPORTANT:
//  * You must specify supported algorithms for your application. See
//  * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
//  * for a list of spec-compliant algorithms.
//  */
// $jwt = JWT::encode($payload, $key);
// $decoded = JWT::decode($jwt, $key, array('HS256'));

// print_r($decoded);

// $user = new Usuario;

// $user->name = 'Mario';

// echo $user->name;