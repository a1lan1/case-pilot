<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

interface Rule
{
    public function isSatisfied(): bool;

    public function getErrorMessage(): string;
}
