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
 * POST /api/tasks
 *
 * Crea una nueva tarea.
 *
 * Body JSON esperado:
 * {
 *   "title": "string (requerido)",
 *   "description": "string (opcional)"
 * }
 */
class CreateTaskHandler implements RequestHandlerInterface
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        // Validación básica
        if (empty($body['title'])) {
            return new JsonResponse(['error' => 'El campo "title" es requerido.'], 422);
        }

        $task = new Task(
            title: trim($body['title']),
            description: isset($body['description']) ? trim($body['description']) : null,
        );

        $this->repository->save($task);

        return new JsonResponse($task->toArray(), 201);
    }
}
