<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use App\Domain\EventBus;
use App\Domain\EventOutbox;
use App\Domain\Transaction;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'outbox:deliver')]
class DeliverOutbox extends Command
{
    public function __construct(private EventOutbox $outbox, private EventBus $eventBus, private Transaction $transaction)
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        while ($event = $this->outbox->oldest()) {
            $this->transaction->begin();
            try {
                $this->outbox->remove($event);
                $this->eventBus->publish($event);
            } catch (\Throwable $throwable) {
                $this->transaction->rollBack();
                throw $throwable;
            }
            $this->transaction->commit();
        }
        return Command::SUCCESS;
    }
}