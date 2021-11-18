<?php

namespace YoungMayor\LaravelWebService\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \YoungMayor\LaravelWebService\Skeleton\SkeletonClass
 */
class LaravelWebService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-web-service';
    }
}
