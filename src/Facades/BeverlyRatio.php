<?php

namespace Xbigdaddyx\BeverlyRatio\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xbigdaddyx\BeverlyRatio\BeverlyRatio
 */
class BeverlyRatio extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'BeverlyRatio';
    }
}
