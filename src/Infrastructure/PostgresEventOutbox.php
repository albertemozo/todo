<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\DomainEvent;
use App\Domain\EventOutbox;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;

class PostgresEventOutbox implements EventOutbox
{
    private PDO $connection;

    public function __construct(Postgres $postgres)
    {
        $this->connection = $postgres->pdo();
    }

    public function record(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $query = "INSERT INTO event_outbox (id, aggregate_id, occurred_on, type, data) VALUES (:id, :aggregateId, :occurredOn, :type, :data)";
            $stmt = $this->connection->prepare($query);

            $id = $event->id();
            $aggregateId = $event->aggregateId();
            $occurredOn = $event->occurredOn()->format(DateTimeInterface::ATOM);
            $type = get_class($event);
            $data = $event->jsonSerialize();

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':aggregateId', $aggregateId);
            $stmt->bindParam(':occurredOn', $occurredOn);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':data', $data);

            $stmt->execute();
        }
    }

    public function next(): DomainEvent|null
    {
        $query = "SELECT * FROM event_outbox ORDER BY occurred_on DESC LIMIT 1";
        $stmt = $this->connection->query($query);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return $row['type']::fromJson($row['id'], $row['aggregate_id'], new DateTimeImmutable($row['occurred_on']), $row['data']);
    }

    public function remove(DomainEvent $event): void
    {
        $query = "DELETE FROM event_outbox WHERE id = :id";
        $stmt = $this->connection->prepare($query);

        $id = $event->id();

        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    public function pop(): DomainEvent|null
    {
        $query = "SELECT * FROM event_outbox ORDER BY occurred_on DESC LIMIT 1";
        $stmt = $this->connection->query($query);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        $query = "DELETE FROM event_outbox WHERE id = :id";
        $stmt = $this->connection->prepare($query);

        $id = $row['id'];

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $row['type']::fromJson($row['id'], $row['aggregate_id'], new DateTimeImmutable($row['occurred_on']), $row['data']);;
    }
}