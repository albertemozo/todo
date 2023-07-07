<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Cli;

use App\Domain\TodoRepository;
use App\Infrastructure\Cli\DeliverOutbox;
use App\Infrastructure\InMemoryTodoRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DeliverOutboxShould extends KernelTestCase
{
    /**
     * @test
     */
    public function execute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $repository = new InMemoryTodoRepository([]);
        $kernel->getContainer()->set(TodoRepository::class, $repository);

        $command = $application->find('outbox:deliver');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
    }

}
