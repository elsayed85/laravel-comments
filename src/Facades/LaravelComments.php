<?php

namespace Spatie\LaravelComments\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\LaravelComments\LaravelComments
 */
class LaravelComments extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-comments';
    }
}
