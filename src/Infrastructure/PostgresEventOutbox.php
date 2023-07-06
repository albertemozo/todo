<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\DomainEvent;
use App\Domain\EventOutbox;
use PDO;
use Ramsey\Uuid\Uuid;

class PostgresEventOutbox implements EventOutbox
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
        $query = "INSERT INTO event_outbox (id, type, data) VALUES (:id, :type, :data)";
        $stmt = $this->connection->prepare($query);

        $id = Uuid::uuid4()->toString();
        $type = get_class($event);
        $data = $event->jsonSerialize();

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':data', $data);

        $stmt->execute();
    }
}