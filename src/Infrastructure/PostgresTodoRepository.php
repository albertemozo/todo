<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\DomainEvent;
use App\Domain\Todo;
use App\Domain\TodoRepository;
use PDO;
use Ramsey\Uuid\Uuid;
use Throwable;

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
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        $todos = [];

        foreach ($records as $record) {
            $todos[] = Todo::rebuild($record['id'], $record['description']);
        }

        return $todos;
    }

    public function save(Todo $todo): void
    {
        $this->connection->beginTransaction();

        try {
            foreach ($todo->pullDomainEvents() as $event) {
                $this->saveInTheOutbox($event);
            }

            $query = "INSERT INTO todos (id, description) VALUES (:id, :description)";
            $stmt = $this->connection->prepare($query);

            $id = $todo->id();
            $description = $todo->description();

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':description', $description);

            $stmt->execute();
        } catch (Throwable $throwable) {
            $this->connection->rollBack();
            throw $throwable;
        }

        $this->connection->commit();
    }

    public function beginTransaction(): void
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

    private function saveInTheOutbox(DomainEvent $event): void
    {
        $query = "INSERT INTO event_outbox (id, body) VALUES (:id, :body)";
        $stmt = $this->connection->prepare($query);

        $id = Uuid::uuid4()->toString();
        $body = $event->jsonSerialize();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':body', $body);

        $stmt->execute();
    }
}