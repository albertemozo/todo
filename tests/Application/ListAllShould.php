<?php

declare(strict_types=1);

namespace Tests\Application;

use App\Application\ListAll;
use App\Domain\Todo;
use App\Infrastructure\InMemoryTodoRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ListAllShould extends TestCase
{
    /**
     * @test
     */
    public function listAllTodos(): void
    {
        $todo = new Todo(Uuid::uuid4()->toString(), 'Laundry');
        $repository = new InMemoryTodoRepository([$todo]);
        $listAll = new ListAll($repository);

        $this->assertNotEmpty(array_filter($listAll(), static fn(Todo $todo) => $todo->description() === 'Laundry'));
    }
}
