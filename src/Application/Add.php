<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\EventOutbox;
use App\Domain\Todo;
use App\Domain\TodoRepository;
use App\Domain\Transaction;
use Ramsey\Uuid\Uuid;
use Throwable;

readonly class Add
{
    public function __construct(
        private TodoRepository $todoRepository,
        private EventOutbox $eventOutbox,
        private Transaction $transaction
    )
    {
    }

    public function __invoke(string $description): void
    {
        $todo = Todo::create(Uuid::uuid4()->toString(), $description);

        $this->transaction->begin();

        try {
            $this->todoRepository->save($todo);
            $this->eventOutbox->record(...$todo->pullDomainEvents());
        } catch (Throwable $throwable) {
            $this->transaction->rollBack();
            throw $throwable;
        }

        $this->transaction->commit();
    }
}