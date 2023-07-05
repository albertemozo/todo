<?php

declare(strict_types=1);

namespace Infrastructure\Cli;

use App\Domain\TodoRepository;
use App\Infrastructure\Persistence\InMemoryTodoRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AddTodoShould extends KernelTestCase
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

        $command = $application->find('todo:add');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'todo' => 'Laundry'
        ]);

        $commandTester->assertCommandIsSuccessful();
    }

    /**
     * @test
     */
    public function addAnItem(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $repository = new InMemoryTodoRepository([]);
        $kernel->getContainer()->set(TodoRepository::class, $repository);

        $command = $application->find('todo:add');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'todo' => 'Laundry'
        ]);

        self::assertContains('Laundry', $repository->allRecords());
    }
}
