<?php

declare(strict_types=1);

namespace App\Application;

class ListAll
{
    public function __invoke(): array
    {
        return ['Laundry'];
    }
}