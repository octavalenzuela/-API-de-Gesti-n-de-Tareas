<?php

declare(strict_types=1);

namespace App\Task\Handler;

use App\Task\Repository\TaskRepository;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * DELETE /api/tasks/{id}
 *
 * Elimina una tarea. Devuelve 204 No Content si tuvo éxito.
 */
class DeleteTaskHandler implements RequestHandlerInterface
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

        $this->repository->delete($task);

        return new EmptyResponse(204);
    }
}
