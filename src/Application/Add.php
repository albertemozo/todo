<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Todo;
use App\Domain\TodoRepository;
use Ramsey\Uuid\Uuid;

class Add
{
    public function __construct(private readonly TodoRepository $todoRepository)
    {
    }

    public function __invoke(string $description): void
    {
        $todo = new Todo(Uuid::uuid4()->toString(), $description);
        $this->todoRepository->save($todo);
    }
}