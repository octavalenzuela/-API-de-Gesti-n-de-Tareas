<?php

declare(strict_types=1);

namespace App\Task\Handler;

use App\Task\Repository\TaskRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * PUT /api/tasks/{id}
 *
 * Actualiza título, descripción y/o estado de una tarea.
 *
 * Body JSON esperado (todos opcionales, pero al menos uno):
 * {
 *   "title": "string",
 *   "description": "string|null",
 *   "status": "pending|in_progress|done"
 * }
 */
class UpdateTaskHandler implements RequestHandlerInterface
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

        $body = $request->getParsedBody();

        if (isset($body['title'])) {
            $task->updateTitle(trim($body['title']));
        }

        if (array_key_exists('description', $body)) {
            $task->updateDescription($body['description'] !== null ? trim($body['description']) : null);
        }

        if (isset($body['status'])) {
            try {
                $task->changeStatus($body['status']);
            } catch (\InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 422);
            }
        }

        $this->repository->save($task);

        return new JsonResponse($task->toArray());
    }
}
