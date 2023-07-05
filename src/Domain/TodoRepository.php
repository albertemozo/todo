<?php

declare(strict_types=1);

namespace App\Domain;

interface TodoRepository
{
    /**
     * @return Todo[]
     */
    public function all(): array;

    public function save(string $todo): void;
}