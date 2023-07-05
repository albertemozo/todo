<?php

declare(strict_types=1);

namespace Application;

use App\Application\ListAll;
use App\Domain\Todo;
use App\Infrastructure\Persistence\InMemoryTodoRepository;
use PHPUnit\Framework\TestCase;

class ListAllShould extends TestCase
{
    /**
     * @test
     */
    public function listAllTodos(): void
    {
        $repository = new InMemoryTodoRepository(['Laundry']);
        $listAll = new ListAll($repository);

        $this->assertNotEmpty(array_filter($listAll(), static fn(Todo $todo) => $todo->description() === 'Laundry'));
    }
}
