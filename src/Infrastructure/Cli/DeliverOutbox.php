<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use App\Domain\DomainEvent;
use App\Domain\EventBus;
use App\Domain\EventOutbox;
use App\Domain\Transaction;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(name: 'outbox:deliver')]
class DeliverOutbox extends Command
{
    public function __construct(
        private readonly EventOutbox $outbox,
        private readonly EventBus    $eventBus,
        private readonly Transaction $transaction
    )
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->transaction->begin();
        try {
            $event = $this->outbox->pop();

            if ($event === null) {
                return Command::SUCCESS;
            }

            $this->eventBus->publish($event);
        } catch (Throwable $throwable) {
            $this->transaction->rollBack();
            throw $throwable;
        }
        $this->transaction->commit();

        return Command::SUCCESS;
    }

}