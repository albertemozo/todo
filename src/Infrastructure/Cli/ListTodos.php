<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use App\Application\ListAll;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'todo:list')]
class ListTodos extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $todos = (new ListAll())();

        foreach ($todos as $todo) {
            $output->writeln($todo);
        }

        return Command::SUCCESS;
    }
}