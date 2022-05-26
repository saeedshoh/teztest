<?php namespace App\Modules\Common\Traits;


trait CacheQuery
{
    public static function getCacheKey($methodName)
    {
        return str_replace('\\', '.', strtolower($methodName));
    }

}
