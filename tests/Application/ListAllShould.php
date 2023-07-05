<?php

declare(strict_types=1);

namespace Application;

use App\Application\ListAll;
use App\Infrastructure\Persistence\InMemoryTodoRepository;
use PHPUnit\Framework\TestCase;

class ListAllShould extends TestCase
{
    /**
     * @test
     */
    public function listAllTodos(): void
    {
        $repository = new InMemoryTodoRepository(['Laundry']);
        $listAll = new ListAll($repository);
        $this->assertContains('Laundry', $listAll());
    }
}
