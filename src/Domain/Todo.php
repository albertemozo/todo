<?php

declare(strict_types=1);

namespace App\Domain;

class Todo
{
    public function __construct(private readonly string $id, private string $description)
    {
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