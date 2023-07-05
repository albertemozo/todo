<?php

declare(strict_types=1);

namespace Infrastructure\Cli;

use App\Infrastructure\Cli\Add;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AddShould extends KernelTestCase
{
    /**
     * @test
     */
    public function execute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('todo:add');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'todo' => 'Laundry'
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
