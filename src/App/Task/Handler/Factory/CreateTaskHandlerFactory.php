<?php

declare(strict_types=1);

namespace App\Task\Handler\Factory;

use App\Task\Handler\CreateTaskHandler;
use App\Task\Repository\TaskRepository;
use Psr\Container\ContainerInterface;

class CreateTaskHandlerFactory
{
    public function __invoke(ContainerInterface $container): CreateTaskHandler
    {
        return new CreateTaskHandler($container->get(TaskRepository::class));
    }
}
