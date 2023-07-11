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

    public function save(DomainEvent ...$events): void
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

    public function next(): DomainEvent|null
    {
        return $this->events[0] ?? null;
    }

    public function remove(DomainEvent $event): void
    {
        $key = array_search($event, $this->events, true);

        if (!is_int($key)) {
            throw new RuntimeException('Event not found.');
        }

        array_splice($this->events, $key);
    }
}