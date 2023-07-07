<?php

declare(strict_types=1);

namespace App\Domain;

interface Transaction
{
    public function begin(): void;

    public function rollBack(): void;

    public function commit(): void;
}