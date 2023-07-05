<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Cli;

use App\Domain\Todo;
use App\Domain\TodoRepository;
use App\Infrastructure\Persistence\InMemoryTodoRepository;
use Ramsey\Uuid\Uuid;
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

        $todo = new Todo(Uuid::uuid4()->toString(), 'Laundry');
        $repository = new InMemoryTodoRepository([$todo]);
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


        $laundry = new Todo(Uuid::uuid4()->toString(), 'Laundry');
        $cleaning = new Todo(Uuid::uuid4()->toString(), 'Cleaning');
        $repository = new InMemoryTodoRepository([$laundry, $cleaning]);
        $kernel->getContainer()->set(TodoRepository::class, $repository);

        $command = $application->find('todo:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Laundry', $output);
        $this->assertStringContainsString('Cleaning', $output);
    }
}