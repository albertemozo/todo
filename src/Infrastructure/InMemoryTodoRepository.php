<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Todo;
use App\Domain\TodoRepository;

class InMemoryTodoRepository implements TodoRepository
{
    /**
     * @param Todo[] $todos
     */
    public function __construct(private array $todos = [])
    {
    }

    public function all(): array
    {
       return $this->todos;
    }

    public function save(Todo $todo): void
    {
        $this->todos[] = $todo;
    }
}