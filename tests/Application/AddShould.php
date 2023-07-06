<?php

declare(strict_types=1);

namespace Tests\Application;

use App\Application\Add;
use App\Domain\Todo;
use App\Infrastructure\InMemoryEventBus;
use App\Infrastructure\InMemoryTodoRepository;
use PHPUnit\Framework\TestCase;

class AddShould extends TestCase
{
    /**
     * @test
     */
    public function addAnItem(): void
    {
        $repository = new InMemoryTodoRepository();
        $eventBus = new InMemoryEventBus();
        $add = new Add($repository, $eventBus);
        $add('Laundry');

        $this->assertNotEmpty(array_filter(
            $repository->all(),
            static fn(Todo $todo) => $todo->description() === 'Laundry'
        ));
    }
}
