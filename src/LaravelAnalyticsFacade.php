<?php

namespace WdevRs\LaravelAnalytics;

use Illuminate\Support\Facades\Facade;

/**
 * @see \WdevRs\LaravelAnalytics\Skeleton\SkeletonClass
 */
class LaravelAnalyticsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-analytics';
    }
}
