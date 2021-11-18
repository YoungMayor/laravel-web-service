<?php

namespace YoungMayor\WebService\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \YoungMayor\LaravelWebService\Skeleton\SkeletonClass
 */
class WebService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'web-service';
    }
}
