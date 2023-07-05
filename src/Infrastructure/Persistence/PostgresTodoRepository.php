<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\TodoRepository;
use PDO;
use PDOException;

class PostgresTodoRepository implements TodoRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = new PDO(
            "pgsql:host=db;port=5432;dbname=database",
            'username',
            'password'
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function all(): array
    {
        $statement = $this->connection->query('SELECT * FROM todos');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(string $todo): void
    {
        // Generate a new UUID

        $query = "INSERT INTO todos (id, description) VALUES (gen_random_uuid(), :description)";
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':description', $todo);

        $stmt->execute();
    }
}