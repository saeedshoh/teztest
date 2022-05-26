<?php namespace App\Modules\AdvertisingBammers\Repositories;


use App\Modules\AdvertisingBammers\Models\AdvertisingBanner;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdvertisingBannerRepository
{


    public function getAll()
    {
        $key = 'AdvertisingBannerRepository_getAll';

        $query = Cache::get($key);

        if($query === null) {
            $query = AdvertisingBanner::where('status', 'ACTIVE')->get();
            Cache::put($key, $query, env('CACHE_TTL_DEFAULT'));
        }

        return $query;
    }

}
