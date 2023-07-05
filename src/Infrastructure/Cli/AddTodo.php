<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use App\Application\Add;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'todo:add')]
class AddTodo extends Command
{
    private const ARGUMENT_DESCRIPTION = 'description';

    public function __construct(private readonly Add $add)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                self::ARGUMENT_DESCRIPTION,
                InputArgument::REQUIRED,
                'The TODO item description.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $description = (string)$input->getArgument(self::ARGUMENT_DESCRIPTION);
        ($this->add)($description);
        return Command::SUCCESS;
    }
}