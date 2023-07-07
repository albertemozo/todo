<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Transaction;

class InMemoryTransaction implements Transaction
{
    public function begin(): void
    {
    }

    public function rollBack(): void
    {
    }

    public function commit(): void
    {
    }
}