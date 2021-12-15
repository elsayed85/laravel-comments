<?php

namespace Spatie\Comments\Exceptions;

use Exception;

class InvalidConfig extends Exception
{
    public static function couldNotDetermineUserModelName(): self
    {
        return new self("Could not determine the user model name. Make sure you specified a valid user model in the comments config file");
    }
}
