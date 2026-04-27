<?php

declare(strict_types=1);

namespace App\Task\Handler;

use App\Task\Entity\Task;
use App\Task\Repository\TaskRepository;
use DateTimeImmutable;
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

        if (!empty($body['due_date'])){
            $due_date = DateTimeImmutable::createFromFormat('Y-m-d', $body['due_date']);
            if (!$due_date || $due_date->format('Y-m-d') !== $body['due_date']) {
                return new JsonResponse(['error' => 'El campo "due_date" debe tener el formato YYYY-MM-DD.'], 422);
            }

            $task->updateDueDate($due_date);
        }

        $this->repository->save($task);

        return new JsonResponse($task->toArray(), 201);
    }
}
