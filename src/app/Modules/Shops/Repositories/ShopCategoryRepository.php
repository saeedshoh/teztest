<?php namespace App\Modules\Shops\Repositories;


use App\Modules\Shops\Models\ShopCategory;

class ShopCategoryRepository
{
    public function getAll()
    {
        return ShopCategory::get();
    }
}
