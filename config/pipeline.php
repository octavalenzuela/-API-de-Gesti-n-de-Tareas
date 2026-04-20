<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Psr\Container\ContainerInterface;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->pipe(\Mezzio\Helper\ServerUrlMiddleware::class);
    $app->pipe(\Mezzio\Router\Middleware\RouteMiddleware::class);
    $app->pipe(\Mezzio\Helper\UrlHelperMiddleware::class);
    $app->pipe(\Mezzio\Router\Middleware\DispatchMiddleware::class);
    $app->pipe(\Mezzio\Handler\NotFoundHandler::class);
};
