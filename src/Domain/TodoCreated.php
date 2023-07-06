<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeImmutable;
use JsonException;

readonly class TodoCreated implements DomainEvent
{
    private DateTimeImmutable $occurredAt;

    public function __construct(private string $id, private string $description)
    {
        $this->occurredAt = new DateTimeImmutable();
    }

    /**
     * @throws JsonException
     */
    public function jsonSerialize(): string
    {
        return json_encode([
            'occurred_at' => $this->occurredAt->getTimestamp(),
            'aggregate_id' => $this->id,
            'description' => $this->description,
        ], JSON_THROW_ON_ERROR);
    }
}