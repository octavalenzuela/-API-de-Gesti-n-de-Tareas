<?php

declare(strict_types=1);

namespace AppTest\Task\Entity;

use App\Task\Entity\Task;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitarios para la entidad Task.
 */
class TaskTest extends TestCase
{
    public function testCreatesTaskWithDefaultStatus(): void
    {
        $task = new Task('Mi primera tarea');

        $this->assertSame('Mi primera tarea', $task->getTitle());
        $this->assertNull($task->getDescription());
        $this->assertSame('pending', $task->getStatus());
        $this->assertNull($task->getId());
    }

    public function testCreatesTaskWithDescription(): void
    {
        $task = new Task('Tarea con descripción', 'Descripción de prueba');

        $this->assertSame('Descripción de prueba', $task->getDescription());
    }

    public function testCanChangeStatus(): void
    {
        $task = new Task('Tarea');
        $task->changeStatus('in_progress');

        $this->assertSame('in_progress', $task->getStatus());
    }

    public function testCanMarkAsDone(): void
    {
        $task = new Task('Tarea');
        $task->changeStatus('done');

        $this->assertSame('done', $task->getStatus());
    }

    public function testThrowsExceptionForInvalidStatus(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $task = new Task('Tarea');
        $task->changeStatus('invalido');
    }

    public function testCanUpdateTitle(): void
    {
        $task = new Task('Título original');
        $task->updateTitle('Título nuevo');

        $this->assertSame('Título nuevo', $task->getTitle());
    }

    public function testCanClearDescription(): void
    {
        $task = new Task('Tarea', 'descripción');
        $task->updateDescription(null);

        $this->assertNull($task->getDescription());
    }

    public function testToArrayContainsExpectedKeys(): void
    {
        $task  = new Task('Tarea', 'desc');
        $array = $task->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('description', $array);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
    }
}
