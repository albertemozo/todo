<?php

declare(strict_types=1);

namespace App\Domain;

use JsonException;

readonly class TodoCreated implements DomainEvent
{
    public function __construct(private readonly string $id, private readonly string $description)
    {
    }

    /**
     * @throws JsonException
     */
    public function jsonSerialize(): string
    {
        return json_encode([
            'aggregateId' => $this->id,
            'description' => $this->description,
        ], JSON_THROW_ON_ERROR);
    }
}