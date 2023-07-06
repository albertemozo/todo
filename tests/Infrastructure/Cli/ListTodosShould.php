<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Cli;

use App\Domain\Todo;
use App\Domain\TodoRepository;
use App\Infrastructure\InMemoryTodoRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ListTodosShould extends KernelTestCase
{
    /**
     * @test
     */
    public function listAllTodos(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);


        $laundry = Todo::rebuild(Uuid::uuid4()->toString(), 'Laundry');
        $cleaning = Todo::rebuild(Uuid::uuid4()->toString(), 'Cleaning');
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