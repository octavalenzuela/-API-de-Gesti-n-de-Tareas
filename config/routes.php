<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;
use App\Task\Handler\ListTasksHandler;
use App\Task\Handler\CreateTaskHandler;
use App\Task\Handler\GetTaskHandler;
use App\Task\Handler\UpdateTaskHandler;
use App\Task\Handler\DeleteTaskHandler;

/**
 * Definición de rutas de la API.
 *
 * GET    /api/tasks          -> Listar todas las tareas
 * POST   /api/tasks          -> Crear una tarea nueva
 * GET    /api/tasks/{id}     -> Obtener una tarea por ID
 * PUT    /api/tasks/{id}     -> Actualizar una tarea
 * DELETE /api/tasks/{id}     -> Eliminar una tarea
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/api/tasks', ListTasksHandler::class, 'tasks.list');
    $app->post('/api/tasks', CreateTaskHandler::class, 'tasks.create');
    $app->get('/api/tasks/{id:\d+}', GetTaskHandler::class, 'tasks.get');
    $app->put('/api/tasks/{id:\d+}', UpdateTaskHandler::class, 'tasks.update');
    $app->delete('/api/tasks/{id:\d+}', DeleteTaskHandler::class, 'tasks.delete');
};
