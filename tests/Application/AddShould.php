<?php

declare(strict_types=1);

namespace Application;

use App\Application\Add;
use App\Domain\Todo;
use App\Infrastructure\Persistence\InMemoryTodoRepository;
use PHPUnit\Framework\TestCase;

class AddShould extends TestCase
{
    /**
     * @test
     */
    public function beCallable(): void
    {
        $this->expectNotToPerformAssertions();
        $repository = new InMemoryTodoRepository();
        $add = new Add($repository);
        $add('Laundry');
    }

    /**
     * @test
     */
    public function addAnItem(): void
    {
        $repository = new InMemoryTodoRepository();
        $add = new Add($repository);
        $add('Laundry');

        $this->assertNotEmpty(array_filter($repository->all(), static fn(Todo $todo) => $todo->description() === 'Laundry'));
    }
}
