<?php namespace App\Modules\Products\Repositories;


use App\Modules\Common\Traits\CacheQuery;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductCategory;

use Illuminate\Support\Facades\Cache;

class CategoryRepository
{
    use CacheQuery;

    public function getAllCategories()
    {
        $key = self::getCacheKey(__METHOD__);
        $query = Cache::get($key);

        if($query == null) {
            $cat = ProductCategory::get()->toArray();
            $query = $this->buildTree($cat);
            Cache::put($key, $query, config('cache.stores.cache_ttl_default'));
        }

        return $query;
    }


    public function buildTree(array &$elements, $parentId = null): array
    {
        $productCatCounts = ProductCategory::withCount('products')->get()->pluck('products_count', 'id')->toArray();
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);

                $element['sub_category'] = [];
                if ($children) {
                    $element['sub_category'] = $children;
                }
                if(empty($element['sub_category']) && $productCatCounts[$element['id']] == 0){
                    continue;
                }
                $branch[] = $element;

            }
        }
        return $branch;
    }

    public function getCategoriesByShopId($shopId): array
    {
        $key = self::getCacheKey(__METHOD__) . $shopId;
        $query = Cache::get($key);

        if($query == null){
            $getProductCats = Product::distinct()
                ->select('product_category_id')
                ->where(['shop_id' => $shopId, 'status' => 'ACTIVE'])
                ->get()->pluck('product_category_id')->toArray();

            $query = ProductCategory::whereIn('id',  $getProductCats)->get()->toArray();
            Cache::put($key, $query, config('cache.stores.cache_ttl_default'));
        }

        return $query;
    }


}
