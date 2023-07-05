<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Cli;

use App\Domain\Todo;
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
    public function addAnItem(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $repository = new InMemoryTodoRepository([]);
        $kernel->getContainer()->set(TodoRepository::class, $repository);

        $command = $application->find('todo:add');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'description' => 'Laundry'
        ]);

        $this->assertNotEmpty(array_filter($repository->all(), static fn(Todo $todo) => $todo->description() === 'Laundry'));
    }
}
