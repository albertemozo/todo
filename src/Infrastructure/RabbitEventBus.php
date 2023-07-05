<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\DomainEvent;
use App\Domain\EventBus;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitEventBus implements EventBus
{
    public function publish(DomainEvent ...$events): void
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'username', 'password');
        $channel = $connection->channel();

        $channel->queue_declare('events', false, false, false, false);

        foreach ($events as $event) {
            $message = new AMQPMessage($event->jsonSerialize());
            $channel->basic_publish($message, '', 'events');
        }

        $channel->close();
        $connection->close();
    }
}