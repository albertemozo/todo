<?php

declare(strict_types=1);

namespace App\Domain;

interface TodoRepository
{
    /**
     * @return Todo[]
     */
    public function all(): array;

    public function save(Todo $todo): void;

    public function beginTransaction(): void;

    public function rollBack(): void;

    public function commit(): void;
}