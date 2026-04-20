<?php

declare(strict_types=1);

namespace App\Task\Repository;

use App\Task\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Repositorio de tareas.
 *
 * Encapsula todas las operaciones de persistencia relacionadas con Task.
 * Los Handlers nunca deben acceder al EntityManager directamente.
 */
class TaskRepository
{
    private EntityRepository $repo;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Task::class);
    }

    /** @return Task[] */
    public function findAll(): array
    {
        return $this->repo->findAll();
    }

    public function findById(int $id): ?Task
    {
        return $this->repo->find($id);
    }

    public function save(Task $task): void
    {
        $this->em->persist($task);
        $this->em->flush();
    }

    public function delete(Task $task): void
    {
        $this->em->remove($task);
        $this->em->flush();
    }
}
