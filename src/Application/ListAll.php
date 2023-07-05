<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Todo;
use App\Domain\TodoRepository;

class ListAll
{
    public function __construct(private readonly TodoRepository $todoRepository)
    {
    }

    /**
     * @return Todo[]
     */
    public function __invoke(): array
    {
        return $this->todoRepository->all();
    }
}