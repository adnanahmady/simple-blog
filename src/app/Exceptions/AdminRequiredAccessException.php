<?php

namespace App\Exceptions;

class AdminRequiredAccessException extends \Exception
{
    public static function throwUnless(
        mixed $condition,
        string $message = null
    ): void {
        if (!$condition) {
            throw new static($message ?? __(
                'Only admin users are allowed to do this action.'
            ));
        }
    }
}
