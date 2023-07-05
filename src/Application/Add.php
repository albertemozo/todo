<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\TodoRepository;

class Add
{
    public function __construct(private readonly TodoRepository $todoRepository)
    {
    }

    public function __invoke(string $todo): void
    {
        $this->todoRepository->saveString($todo);
    }
}