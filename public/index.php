<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\ResponseEmitter;

require dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->enableCompilation(dirname(__DIR__) . '/var/cache');
$containerBuilder->addDefinitions('../app/services.php');
$app = Bridge::create($containerBuilder->build());

$routes = require dirname(__DIR__) . '/app/routes.php';
$routes($app);

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
