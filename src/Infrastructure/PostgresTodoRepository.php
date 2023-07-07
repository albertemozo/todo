<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\EventOutbox;
use App\Domain\Todo;
use App\Domain\TodoRepository;
use PDO;
use Throwable;

class PostgresTodoRepository implements TodoRepository
{
    private PDO $connection;
    private EventOutbox $eventOutbox;

    public function __construct()
    {
        $this->connection = new PDO(
            "pgsql:host=db;port=5432;dbname=database",
            'username',
            'password'
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->eventOutbox = new PostgresEventOutbox();
    }

    public function all(): array
    {
        $statement = $this->connection->query('SELECT * FROM todos');
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        $todos = [];

        foreach ($records as $record) {
            $todos[] = Todo::rebuild($record['id'], $record['description']);
        }

        return $todos;
    }

    public function save(Todo $todo): void
    {
        $this->eventOutbox->save(...$todo->pullDomainEvents());

        $query = "INSERT INTO todos (id, description) VALUES (:id, :description)";
        $stmt = $this->connection->prepare($query);

        $id = $todo->id();
        $description = $todo->description();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $description);

        $stmt->execute();
    }

    public function connection(): PDO
    {
        return $this->connection;
    }
}