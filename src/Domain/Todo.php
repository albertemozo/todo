<?php

declare(strict_types=1);

namespace App\Domain;

class Todo
{
    /**
     * @var DomainEvent[]
     */
    private array $domainEvents = [];

    public function __construct(private readonly string $id, private readonly string $description)
    {
        $this->recordThat(new TodoCreated($id, $description));
    }

    public static function create(string $id, string $description): self
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

    /**
     * @return DomainEvent[]
     */
    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }

    private function recordThat(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }
}