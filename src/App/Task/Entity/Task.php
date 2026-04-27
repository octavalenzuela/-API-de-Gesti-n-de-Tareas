<?php

declare(strict_types=1);

namespace App\Task\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidad principal del dominio.
 *
 * Representa una tarea pendiente con título, descripción,
 * estado y fechas de auditoría.
 */
#[ORM\Entity]
#[ORM\Table(name: 'tasks')]
#[ORM\HasLifecycleCallbacks]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    /**
     * Estado posible: 'pending', 'in_progress', 'done'
     */
    #[ORM\Column(type: 'string', length: 20)]
    private string $status = 'pending';

    #[ORM\Column(name: 'due_date', type: 'date_immutable', nullable: true)]
    private ?DateTimeImmutable $dueDate = null; 

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function __construct(string $title, ?string $description = null)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->createdAt   = new DateTimeImmutable();
        $this->updatedAt   = new DateTimeImmutable();
    }

    // --- Getters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDueDate(): ?DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    // --- Setters / comportamiento ---

    public function updateTitle(string $title): void
    {
        $this->title = $title;
    }

    public function updateDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function updateDueDate(?DateTimeImmutable $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    public function changeStatus(string $status): void
    {
        $allowed = ['pending', 'in_progress', 'done'];
        if (!in_array($status, $allowed, true)) {
            throw new \InvalidArgumentException(
                "Estado inválido: '$status'. Permitidos: " . implode(', ', $allowed)
            );
        }
        $this->status = $status;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * Devuelve la representación en array para serializar a JSON.
     */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'due_date'    => $this->dueDate?->format('Y-m-d'),
            'created_at'  => $this->createdAt->format(DATE_ATOM),
            'updated_at'  => $this->updatedAt->format(DATE_ATOM),
        ];
    }
}