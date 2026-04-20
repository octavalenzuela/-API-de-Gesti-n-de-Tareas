<?php

declare(strict_types=1);

namespace App\Task\Handler;

use App\Task\Repository\TaskRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * GET /api/tasks/{id}
 *
 * Devuelve una tarea específica por su ID.
 */
class GetTaskHandler implements RequestHandlerInterface
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id   = (int) $request->getAttribute('id');
        $task = $this->repository->findById($id);

        if ($task === null) {
            return new JsonResponse(['error' => 'Tarea no encontrada.'], 404);
        }

        return new JsonResponse($task->toArray());
    }
}
