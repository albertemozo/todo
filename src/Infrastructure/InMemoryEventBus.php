<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\DomainEvent;
use App\Domain\EventBus;

class InMemoryEventBus implements EventBus
{
    /**
     * @var DomainEvent[]
     */
    private array $published = [];

    public function publish(DomainEvent ...$events): void
    {
        $this->published = array_merge($this->published, $events);
    }
}