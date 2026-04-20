<?php

declare(strict_types=1);

namespace App\Task\Handler\Factory;

use App\Task\Handler\GetTaskHandler;
use App\Task\Repository\TaskRepository;
use Psr\Container\ContainerInterface;

class GetTaskHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetTaskHandler
    {
        return new GetTaskHandler($container->get(TaskRepository::class));
    }
}
