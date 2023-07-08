<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeImmutable;
use JsonSerializable;

interface DomainEvent extends JsonSerializable
{
    public function id(): string;
    public function aggregateId(): string;
    public function occurredOn(): DateTimeImmutable;
    public static function fromJson(string $id, string $aggregateId, DateTimeImmutable $occurredOn, string $data): self;
}