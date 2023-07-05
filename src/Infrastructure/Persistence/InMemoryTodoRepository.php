<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Todo;
use App\Domain\TodoRepository;

class InMemoryTodoRepository implements TodoRepository
{
    public function __construct(private array $todos = [])
    {
    }

    public function all(): array
    {
       $todos = [];

        foreach ($this->todos as $todo) {
            $todos[] = new Todo('some_id', $todo);
        }

        return $todos;
    }

    public function saveString(string $todo): void
    {
        $this->todos[] = $todo;
    }
}