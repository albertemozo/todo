<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\DomainEvent;
use App\Domain\EventOutbox;
use RuntimeException;

class InMemoryEventOutbox implements EventOutbox
{
    /**
     * @param DomainEvent[] $events
     */
    public function __construct(private array $events = [])
    {
    }

    public function record(DomainEvent ...$events): void
    {
        $this->events = array_merge($this->events, $events);
    }

    /**
     * @return DomainEvent[]
     */
    public function events(): array
    {
        return $this->events;
    }

    public function pop(): DomainEvent|null
    {
        return array_pop($this->events);
    }
}