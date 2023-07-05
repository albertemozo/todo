<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\TodoRepository;

class InMemoryTodoRepository implements TodoRepository
{
    public function __construct(private array $todos = [])
    {
    }

    public function all(): array
    {
        return $this->todos;
    }

    public function save(string $todo): void
    {
        $this->todos[] = $todo;
    }
}