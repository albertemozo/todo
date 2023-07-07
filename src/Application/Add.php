<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Todo;
use App\Domain\TodoRepository;
use App\Domain\Transaction;
use Ramsey\Uuid\Uuid;

readonly class Add
{
    public function __construct(private TodoRepository $todoRepository, private Transaction $transaction)
    {
    }

    public function __invoke(string $description): void
    {
        $todo = Todo::create(Uuid::uuid4()->toString(), $description);

        $this->transaction->begin();

        try {
            $this->todoRepository->save($todo);
        } catch (\Throwable) {
            $this->transaction->rollBack();
        }

        $this->transaction->commit();
    }
}