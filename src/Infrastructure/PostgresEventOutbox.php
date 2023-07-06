<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\DomainEvent;
use PDO;
use Ramsey\Uuid\Uuid;

class PostgresEventOutbox
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

    public function save(DomainEvent $event): void
    {
        $query = "INSERT INTO event_outbox (id, type, body) VALUES (:id, :type, :body)";
        $stmt = $this->connection->prepare($query);

        $id = Uuid::uuid4()->toString();
        $type = get_class($event);
        $body = $event->jsonSerialize();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':body', $body);

        $stmt->execute();
    }
}