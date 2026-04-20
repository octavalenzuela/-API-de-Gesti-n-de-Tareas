<?php

declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Punto de entrada de la aplicación.
 * Carga el contenedor de dependencias, registra las rutas y despacha la petición.
 */
$container = require 'config/container.php';

$app     = $container->get(Application::class);
$factory = $container->get(MiddlewareFactory::class);

(require 'config/pipeline.php')($app, $factory, $container);
(require 'config/routes.php')($app, $factory, $container);

$app->run();
