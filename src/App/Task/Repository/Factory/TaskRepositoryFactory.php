<?php

declare(strict_types=1);

namespace App\Task\Repository\Factory;

use App\Task\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class TaskRepositoryFactory
{
    public function __invoke(ContainerInterface $container): TaskRepository
    {
        return new TaskRepository($container->get(EntityManagerInterface::class));
    }
}
