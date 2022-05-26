<?php

namespace App\Modules\Products\Repositories;

use App\Http\Resources\ProductResource;
use App\Modules\Common\Traits\CacheQuery;
use App\Modules\Products\Models\Brand;
use App\Modules\Products\Services\ProductCategoryService;
use App\Modules\Shops\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Modules\Products\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository
{
    use CacheQuery;

    public function getAll(Request $request)
    {
        $limit = $request->input('limit', 16);
        $orderBy = $request->input('sorting_field', 'rank');
        $direction = $request->input('sorting_direction', 'desc');
        $searchText = $request->input('search_text', "*");


        $query = Product::search($searchText)->with(['shop.city', 'productCategory', 'productMedia', 'brand', 'wishlist']);

        $min = (float) request('price_min', false);
        $max = (float) request('price_max', false);

        $query->when($min && $max, function ($q) use ($min, $max) {
            return $q->where('price', '>=', $min)->where('price', '<=', $max);
        });

        $query->when(request('brand_id', false), function ($q, $brandIds) {
            return $q->whereIn('brand_id', $brandIds);
        });

        $query->when(request('shop_id', false), function ($q, $shopIds) {
            return $q->whereIn('shop_id', $shopIds);
        });

        $query->when(request('product_category_id', false), function ($q, $product_category_ids) {
            $cats = new ProductCategoryService();
            return $q->whereIn('product_category_id', $cats->getCategoryByIds($product_category_ids));
        });

        return ProductResource::collection($query->orderBy($orderBy, $direction)->paginate($limit))
            ->response()
            ->getData(true);
    }

    public function getProductById(int $id): array
    {
        $statusCode = 200;
        try {
            $product = Product::find($id);
            $product->view_count = $product->view_count + 1;
            $product->save();
            $productResource = new ProductResource($product);
        } catch (ModelNotFoundException $e) {
            $productResource = 'Product Not Found';
            $statusCode = 404;
        }

        return ['product' => $productResource, 'statusCode' => $statusCode];
    }

    public function getGeneralFilters()
    {
        $key = self::getCacheKey(__METHOD__);
        $query = Cache::get($key);
        if ($query == null) {
            $existBrandProduct = Product::select('brand_id')->distinct()->get()->pluck('brand_id')->toArray();
            $query['products'] = [
                'maxPrice' => Product::max('price'),
                'minPrice' => Product::min('price')
            ];
            $query['brands'] = Brand::whereIn('id', $existBrandProduct)->get()->pluck('name', 'id');
            $query['shops'] = Shop::where('status', 'ACTIVE')->get()->pluck('name', 'id');
            Cache::put($key, $query, config('cache.stores.cache_ttl_default'));
        }

        return $query;
    }

    public function getShopFilters(int $shopId)
    {
        $key = self::getCacheKey(__METHOD__) . $shopId;
        $query = Cache::get($key);
        if ($query == null) {
            $existBrandProduct = Product::where('shop_id', $shopId)
                ->select('brand_id')->distinct()->get()->pluck('brand_id')->toArray();
            $query['products'] = [
                'maxPrice' => Product::where('shop_id', $shopId)->max('price'),
                'minPrice' => Product::where('shop_id', $shopId)->min('price')
            ];
            $query['brands'] = Brand::whereIn('id', $existBrandProduct)->get()->pluck('name', 'id');
            Cache::put($key, $query, config('cache.stores.cache_ttl_default'));
        }
        return $query;
    }

    /*
    * Получить популярные продукты. Сортировать по количеству заказов
    */
    public function getPopularProducts()
    {
        return ProductResource::collection(Product::withCount('orderProducts')
            ->orderBy('orderProducts_count', 'desc')->take(6)->get());
    }
}
