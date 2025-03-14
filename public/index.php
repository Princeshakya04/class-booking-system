<?php

use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add body parsing middleware
$app->addBodyParsingMiddleware();

// Load routes
(require __DIR__ . '/../src/Routes/routes.php')($app);

$app->run();