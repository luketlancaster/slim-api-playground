<?php

declare(strict_types=1);

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

use PinterestApi\Middleware\SetJsonResponse as JsonResponseMiddleware;
// use PinterestApi\Controller\BaseController;
use PinterestApi\Controller\Boards\GetBoards;
use PinterestApi\Controller\Boards\GetBoardWithPins;
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

// try this later...just create a BaseController for the others to extend?
// then you only need the DI config for that???
// $container->set('BaseController', function() use ($container) {
//     return new BaseController($container->get('PDO'));
// });

// todo: 👆
// deploy to homeserve, and enable Access-Control-Allow-Origin header for just this project
  // nginx config will need to forward request to luna-api-test/public/ (or just move out the index.php?)
  // alternately try a different dev server?
  // do DI correctly. Some kind of config setup to wire this stuff up for you
  // error responses
  // both for bad requests in known routes and unknown routes

$container->set('GetPins', function() use ($container) {
    return new GetPins($container->get('db'));
});

$container->set('GetBoards', function() use ($container) {
    return new GetBoards($container->get('db'));
});

$container->set('GetBoardWithPins', function() use ($container) {
    return new GetBoardWithPins($container->get('db'));
});


$app->get('/pins', $container->get('GetPins'));

$app->group('/boards', function(RouteCollectorProxy $group) {
    $group->get('/{id}/pins', $this->get('GetBoardWithPins'));

    $group->get('', $this->get('GetBoards'));

});

$app->add(new WhoopsMiddleware());
$app->add(new JsonResponseMiddleware());

$app->run();
