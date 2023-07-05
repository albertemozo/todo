<?php

declare(strict_types=1);

namespace App\Domain;

class Todo
{
    public function __construct(private string $id, private string $description)
    {
    }

    public function description(): string
    {
        return $this->description;
    }
}