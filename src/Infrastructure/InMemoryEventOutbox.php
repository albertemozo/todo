<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\DomainEvent;
use App\Domain\EventOutbox;

class InMemoryEventOutbox implements EventOutbox
{
    /**
     * @var DomainEvent[]
     */
    private array $events = [];

    public function save(DomainEvent ...$events): void
    {
        $this->events = array_merge($this->events, $events);
    }
}