<?php

namespace App\functions;

use Slim\Psr7\Response;

function withJson(Response $response, $body): Response
{
    $response->getBody()->write(json_encode($body));
    return $response->withHeader('Content-Type', 'application/json');
}