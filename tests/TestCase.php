<?php

declare(strict_types=1);

namespace Tests;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

class TestCase extends PHPUnit_TestCase
{
    private ?App $app = null;

    protected function getAppInstance(): App
    {
        if ($this->app !== null) {
            return $this->app;
        }

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions('app/variables.php');
        $containerBuilder->addDefinitions('app/services.php');
        $this->app = Bridge::create($containerBuilder->build());

        $routes = require __DIR__ . '/../app/routes.php';
        $routes($this->app);

        return $this->app;
    }

    protected function getContainer(): Container
    {
        /** @var Container $container */
        $container = $this->getAppInstance()->getContainer();

        return $container;
    }

    protected function createRequest(
        string $method,
        string $path,
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $cookies = [],
        array $serverParams = []
    ): Request {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'wb+');
        assert($handle !== false);

        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
    }
}
