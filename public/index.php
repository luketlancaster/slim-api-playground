<?php

declare(strict_types=1);

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

use PinterestApi\Middleware\SetJsonResponse as JsonResponseMiddleware;
use PinterestApi\Controller\Pins\GetPins;

use function DI\create;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

$container->set('db', function() {
    $dsn = 'pgsql:dbname=pinterest;host=localhost';
    $user = 'pinterest';
    $password = 'pinterest';
    $connection = new PDO($dsn, $user, $password);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $connection;
});

$container->set('GetPins', function() use ($container) {
    return new GetPins($container->get('db'));
});

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('hello world!');
    return $response;
});


$app->group('/pins', function(RouteCollectorProxy $group) {
    // $pins = json_decode(file_get_contents(__DIR__ . '/../pins.json'));

    // $group->get('/boards/1', function (Request $request, Response $response, $args) use ($pins) {
    //     $response->getBody()->write(json_encode($pins[$args['id']]));
    //     return $response;
    // });

    $group->get('', $this->get('GetPins'));

})->add(new JsonResponseMiddleware());

$app->add(new WhoopsMiddleware());

$app->run();
