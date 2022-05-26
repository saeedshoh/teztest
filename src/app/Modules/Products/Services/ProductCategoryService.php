<?php


namespace App\Modules\Products\Services;


use App\Modules\Products\Models\ProductCategory;
use Cache;

class ProductCategoryService
{
    public function getSubCategory($catId)
    {
        return $this->getCategoryById($catId);
    }
    public function getCategoriesIds($category): ?array
    {
        if(!empty($category))
        {
            $array = [$category->id];
            if(count($category->subCategory) == 0) {
                return $array;
            }

            return array_merge($array, $this->getChildrenIds($category->subCategory));
        }

        return null;
    }

    private function getChildrenIds($subcategories): array
    {
        $array = [];
        foreach ($subcategories as $subcategory)
        {
            array_push($array, $subcategory->id);
            if(count($subcategory->subCategory)){
                $array = array_merge($array, $this->getChildrenIds($subcategory->subcategory));
            }
        }
        return $array;
    }

    public function getCachedCategories(): array
    {
        $key = 'sub.categories.all';
        $query = Cache::get($key);

        if($query == null){
            $allCategories = ProductCategory::all();
            $cats = [];

            foreach ($allCategories as $cat) {
                $cats[$cat->id] = $this->getCategoriesIds($cat);
            }

            Cache::put($key, $cats, config('cache.stores.cache_ttl_default'));

            return $cats;
        }

        return $query;

    }

    public function getCategoryByIds($catIds)
    {
        $getCategories = $this->getCachedCategories();
        $only = \Arr::only($getCategories, $catIds);

        if(count($catIds) > 1){
            return array_unique(array_merge(...$only));
        }

        return $only[$catIds[0]];
    }
}
