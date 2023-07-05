<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'todo:add')]
class AddTodo extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument(
                'todo',
                InputArgument::REQUIRED,
                'The TODO item.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}