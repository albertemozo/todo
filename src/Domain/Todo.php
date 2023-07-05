<?php

declare(strict_types=1);

namespace App\Domain;

class Todo extends AggregateRoot
{
    public function __construct(private readonly string $id, private readonly string $description)
    {
    }

    public static function create(string $id, string $description): self
    {
        $todo = new self($id, $description);

        $todo->recordThat(new TodoCreated($id, $description));

        return $todo;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function description(): string
    {
        return $this->description;
    }
}