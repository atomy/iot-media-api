<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/health', function (Request $request, Response $response) use ($app) {
        $response = (new \IotMediaApi\Controller\HealthController($app->getContainer()->get(\App\Container::class)))->getHealth($request, $response, []);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/ready', function (Request $request, Response $response) use ($app) {
        $response = (new \IotMediaApi\Controller\HealthController($app->getContainer()->get(\App\Container::class)))->getReady($request, $response, []);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/meta', function (Request $request, Response $response) use ($app) {
        $response = (new \IotMediaApi\Controller\MetaController($app->getContainer()->get(\App\Container::class)))->get($request, $response, []);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/event', function (Request $request, Response $response) use ($app) {
        $response = (new \IotMediaApi\Controller\EventController($app->getContainer()->get(\App\Container::class)))->postEvent($request, $response, []);
        return $response->withHeader('Content-Type', 'application/json');
    });
};
