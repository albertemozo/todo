<?php

declare(strict_types=1);

namespace App\Infrastructure;

use PDO;

class Postgres
{
    private PDO $pdo;

    public function __construct(
        string $host,
        string $port,
        string $database,
        string $username,
        string $password
    )
    {
        $this->pdo = new PDO(
            "pgsql:host={$host};port={$port};dbname={$database}",
            $username,
            $password
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }
}