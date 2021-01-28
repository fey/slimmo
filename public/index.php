<?php

use DI\Bridge\Slim\Bridge;

$container = require __DIR__ . '/../bootstrap.php';
$app = \App\Rest::create((Bridge::create($container)));

// Add Routing Middleware
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.

 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

require_once __DIR__ . '/../src/routes.php';

$app->run();