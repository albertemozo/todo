<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Todo extends AggregateRoot
{
    private function __construct(private readonly string $id, private readonly string $description)
    {
    }

    public static function create(string $id, string $description): self
    {
        $todo = new self($id, $description);
        $todo->recordThat(new TodoCreated(Uuid::uuid4()->toString(), $id, new DateTimeImmutable(), $description));
        return $todo;
    }

    public static function rebuild(string $id, string $description): self
    {
        return new self($id, $description);
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