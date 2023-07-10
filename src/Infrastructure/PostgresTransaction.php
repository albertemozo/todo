<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Transaction;
use PDO;

class PostgresTransaction implements Transaction
{
    private PDO $connection;

    public function __construct(Postgres $postgres)
    {
        $this->connection = $postgres->pdo();
    }

    public function begin(): void
    {
        $this->connection->beginTransaction();
    }

    public function rollBack(): void
    {
        $this->connection->rollBack();
    }

    public function commit(): void
    {
        $this->connection->commit();
    }
}