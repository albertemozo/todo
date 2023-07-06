<?php

declare(strict_types=1);

namespace App\Domain;

interface EventOutbox
{
    public function save(DomainEvent $event): void;
}