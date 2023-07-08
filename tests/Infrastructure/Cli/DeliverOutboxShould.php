<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Cli;

use App\Domain\TodoCreated;
use App\Domain\TodoRepository;
use App\Infrastructure\Cli\DeliverOutbox;
use App\Infrastructure\InMemoryEventOutbox;
use App\Infrastructure\InMemoryTodoRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use App\Domain\EventOutbox;

class DeliverOutboxShould extends KernelTestCase
{
    /**
     * @test
     */
    public function execute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('outbox:deliver');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
    }

    /**
     * @test
     */
    public function emptyTheOutbox(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $outbox = new InMemoryEventOutbox([
            new TodoCreated(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), new DateTimeImmutable(), 'Laundry')
        ]);
        $kernel->getContainer()->set(EventOutbox::class, $outbox);

        $command = $application->find('outbox:deliver');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $this->assertEmpty($kernel->getContainer()->get(EventOutbox::class)->events());
    }

}
