<?php

declare(strict_types=1);

namespace App\Domain;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}