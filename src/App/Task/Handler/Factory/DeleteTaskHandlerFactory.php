<?php

declare(strict_types=1);

namespace App\Task\Handler\Factory;

use App\Task\Handler\DeleteTaskHandler;
use App\Task\Repository\TaskRepository;
use Psr\Container\ContainerInterface;

class DeleteTaskHandlerFactory
{
    public function __invoke(ContainerInterface $container): DeleteTaskHandler
    {
        return new DeleteTaskHandler($container->get(TaskRepository::class));
    }
}
