<?php

declare(strict_types=1);

namespace App\Shared\Domain\Specifications;

interface Specification
{
    public function isSatisfiedBy(object $candidate): bool;

    public function getErrorMessage(): string;
}
