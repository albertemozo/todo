<?php

declare(strict_types=1);

namespace App\Domain;

interface EventOutbox
{
    public function save(DomainEvent ...$events): void;

    public function next(): DomainEvent|null;

    public function remove(DomainEvent $event): void;
}