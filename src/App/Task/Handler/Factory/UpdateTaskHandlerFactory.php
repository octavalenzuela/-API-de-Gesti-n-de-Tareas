<?php

declare(strict_types=1);

namespace App\Task\Handler\Factory;

use App\Task\Handler\UpdateTaskHandler;
use App\Task\Repository\TaskRepository;
use Psr\Container\ContainerInterface;

class UpdateTaskHandlerFactory
{
    public function __invoke(ContainerInterface $container): UpdateTaskHandler
    {
        return new UpdateTaskHandler($container->get(TaskRepository::class));
    }
}
