<?php

declare(strict_types=1);

namespace App\Domain;

interface EventOutbox
{
    public function record(DomainEvent ...$events): void;

    public function pop(): DomainEvent|null;
}