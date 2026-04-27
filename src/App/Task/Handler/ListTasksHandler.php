<?php

declare(strict_types=1);

namespace App\Task\Handler;

use App\Task\Entity\Task;
use App\Task\Repository\TaskRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * GET /api/tasks
 *
 * Devuelve la lista completa de tareas.
 */
class ListTasksHandler implements RequestHandlerInterface
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $status = $queryParams['status'] ?? null;
        $tasks = $this->repository->findByFilters($status);
        $data = array_map(fn($task) => $task->toArray(), $tasks);

        return new JsonResponse($data);
    }
}
