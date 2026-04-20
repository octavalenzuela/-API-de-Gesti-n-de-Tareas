<?php

declare(strict_types=1);

use App\Task\Repository;
use App\Task\Handler;
use App\Infrastructure\Doctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;

return [
    'dependencies' => [
        'factories' => [
            // Doctrine
            EntityManagerInterface::class => EntityManagerFactory::class,

            // Repositorios
            Repository\TaskRepository::class => Repository\Factory\TaskRepositoryFactory::class,

            // Handlers HTTP
            Handler\ListTasksHandler::class   => Handler\Factory\ListTasksHandlerFactory::class,
            Handler\CreateTaskHandler::class  => Handler\Factory\CreateTaskHandlerFactory::class,
            Handler\GetTaskHandler::class     => Handler\Factory\GetTaskHandlerFactory::class,
            Handler\UpdateTaskHandler::class  => Handler\Factory\UpdateTaskHandlerFactory::class,
            Handler\DeleteTaskHandler::class  => Handler\Factory\DeleteTaskHandlerFactory::class,
        ],
    ],
];
