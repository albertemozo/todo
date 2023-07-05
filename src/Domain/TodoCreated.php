<?php

declare(strict_types=1);

namespace App\Domain;

readonly class TodoCreated implements DomainEvent
{
    public function __construct(private readonly string $id, private readonly string $description)
    {
    }
}