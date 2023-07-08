<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeImmutable;
use JsonException;

readonly class TodoCreated implements DomainEvent
{
    public function __construct(
        private string            $id,
        private string            $aggregateId,
        private DateTimeImmutable $occurredOn,
        private string            $description
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function jsonSerialize(): string
    {
        return json_encode([
            'occurred_at' => $this->occurredOn->getTimestamp(),
            'aggregate_id' => $this->aggregateId,
            'description' => $this->description,
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public static function fromJson(string $id, string $aggregateId, DateTimeImmutable $occurredOn, string $data): DomainEvent
    {
        $primitives = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        return new self($id, $aggregateId, $occurredOn, $primitives['description']);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}