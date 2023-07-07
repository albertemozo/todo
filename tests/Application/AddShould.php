<?php

declare(strict_types=1);

namespace Tests\Application;

use App\Application\Add;
use App\Domain\Todo;
use App\Infrastructure\InMemoryTodoRepository;
use App\Infrastructure\InMemoryTransaction;
use PHPUnit\Framework\TestCase;

class AddShould extends TestCase
{
    /**
     * @test
     */
    public function addAnItem(): void
    {
        $repository = new InMemoryTodoRepository();
        $transaction = new InMemoryTransaction();
        $add = new Add($repository, $transaction);
        $add('Laundry');

        $this->assertNotEmpty(array_filter(
            $repository->all(),
            static fn(Todo $todo) => $todo->description() === 'Laundry'
        ));
    }
}
