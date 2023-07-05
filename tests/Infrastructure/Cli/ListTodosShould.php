<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Cli;

use App\Domain\TodoRepository;
use App\Infrastructure\Persistence\InMemoryTodoRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ListTodosShould extends KernelTestCase
{
    /**
     * @test
     */
    public function execute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $repository = new InMemoryTodoRepository(['Laundry']);
        $kernel->getContainer()->set(TodoRepository::class, $repository);

        $command = $application->find('todo:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
    }

    /**
     * @test
     */
    public function listAllTodos(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $repository = new InMemoryTodoRepository(['Laundry', 'Cleaning']);
        $kernel->getContainer()->set(TodoRepository::class, $repository);

        $command = $application->find('todo:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Laundry', $output);
        $this->assertStringContainsString('Cleaning', $output);
    }
}