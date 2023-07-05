<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\EventBus;
use App\Domain\Todo;
use App\Domain\TodoRepository;
use Ramsey\Uuid\Uuid;

readonly class Add
{

    public function __construct(private TodoRepository $todoRepository, private readonly EventBus $eventBus)
    {
    }

    public function __invoke(string $description): void
    {
        $todo = Todo::create(Uuid::uuid4()->toString(), $description);
        $this->todoRepository->save($todo);
        $this->eventBus->publish(...$todo->pullDomainEvents());
    }
}