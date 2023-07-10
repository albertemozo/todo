<?php

declare(strict_types=1);

namespace Tests\Application;

use App\Application\Add;
use App\Domain\DomainEvent;
use App\Domain\EventOutbox;
use App\Domain\Todo;
use App\Domain\TodoRepository;
use App\Domain\Transaction;
use App\Infrastructure\InMemoryEventOutbox;
use App\Infrastructure\InMemoryTodoRepository;
use App\Infrastructure\InMemoryTransaction;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class AddShould extends TestCase
{
    private const SOME_TODO_DESCRIPTION = 'Some TODO description';
    private TodoRepository $repository;
    private EventOutbox $outbox;
    private Transaction $transaction;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryTodoRepository();
        $this->outbox = new InMemoryEventOutbox();
        $this->transaction = new InMemoryTransaction();
    }

    /**
     * @test
     */
    public function addAnItem(): void
    {
        $add = new Add($this->repository, $this->outbox, $this->transaction);

        $add(self::SOME_TODO_DESCRIPTION);

        $this->thenThereIsATodoWithDescription(self::SOME_TODO_DESCRIPTION);
    }

    /**
     * @test
     */
    public function notPersistChangesToTheAggregateIfTheEventsCannotBeRecorded(): void
    {
        $faultyOutbox = new class extends InMemoryEventOutbox {
            public function save(DomainEvent ...$events): void
            {
                throw new RuntimeException('Something went wrong!');
            }
        };

        $add = new Add($this->repository, $faultyOutbox, $this->transaction);

        $this->expectException(RuntimeException::class);

        $add(self::SOME_TODO_DESCRIPTION);

        $this->thenThereIsNotATodoWithDescription(self::SOME_TODO_DESCRIPTION);
    }

    private function thenThereIsATodoWithDescription(string $description): void
    {
        $this->assertNotEmpty(array_filter(
            $this->repository->all(),
            static fn(Todo $todo) => $todo->description() === $description
        ));
    }

    private function thenThereIsNotATodoWithDescription(string $description): void
    {
        $this->assertEmpty(array_filter(
            $this->repository->all(),
            static fn(Todo $todo) => $todo->description() === $description
        ));
    }
}
