<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'todo')]
class Todo extends Command
{
    protected function configure(): void
    {
        $this
            // configure an argument
            ->addArgument('operation', InputArgument::OPTIONAL, 'The operation to be executed.')
            // ...
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $operation = $input->getArgument('operation') ?? 'list';

        if ($operation !== 'list') {
            $output->writeln('Unknown command.');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}