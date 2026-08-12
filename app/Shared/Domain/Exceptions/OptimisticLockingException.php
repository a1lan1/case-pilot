<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exceptions;

use Exception;

class OptimisticLockingException extends Exception
{
    public function __construct()
    {
        parent::__construct('The record has been modified by another user. Please reload and try again.');
    }
}
