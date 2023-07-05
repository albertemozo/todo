<?php

declare(strict_types=1);

namespace Domain;

use App\Domain\DomainEvent;
use App\Domain\Todo;
use App\Domain\TodoCreated;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TodoShould extends TestCase
{
    /**
     * @test
     */
    public function recordAnEventWhenCreated(): void
    {
        $todo = Todo::create(Uuid::uuid4()->toString(), 'Laundry');

        $this->assertNotEmpty(array_filter(
            $todo->pullDomainEvents(),
            static fn(DomainEvent $event) => $event instanceof TodoCreated
        ));
    }
}
