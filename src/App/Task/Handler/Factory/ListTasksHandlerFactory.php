<?php

declare(strict_types=1);

namespace App\Task\Handler\Factory;

use App\Task\Handler\ListTasksHandler;
use App\Task\Repository\TaskRepository;
use Psr\Container\ContainerInterface;

class ListTasksHandlerFactory
{
    public function __invoke(ContainerInterface $container): ListTasksHandler
    {
        return new ListTasksHandler($container->get(TaskRepository::class));
    }
}
