<?php

namespace YoungMayor\LaravelWebService;

use Illuminate\Support\Facades\Facade;

/**
 * @see \YoungMayor\LaravelWebService\Skeleton\SkeletonClass
 */
class LaravelWebServiceFacade extends Facade
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
