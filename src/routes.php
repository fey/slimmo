<?php

use Slim\Psr7\Response;
use Slim\Psr7\Request;

/** @var App\Rest $app */
// Define app routes

use function App\functions\withJson;

$app->get('/hello/{name}', function (Response $response, $name, Request $request ) {
    return withJson($response, [
        'ok' => true
    ]);
});


$app->get('/', function (Request $request, Response $response) use ($app) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->resource('users', \App\UserController::class);
$app->resource('items', \App\ItemController::class);
$app->get('/users/{userId}/inventory', [\App\User\InventoryController::class, 'index']);
$app->post('/users/{userId}/inventory', [\App\User\InventoryController::class, 'add']);
