<?php namespace App\Http\Controllers\API\v0\Shops;


use App\Http\Controllers\Controller;
use App\Modules\Shops\Repositories\ShopCategoryRepository;

class ShopCategoryController extends Controller
{
    private  $shopCategoryRepository;

    public function __construct(ShopCategoryRepository $shopCategoryRepository)
    {
        $this->shopCategoryRepository = $shopCategoryRepository;
    }

    public function index()
    {
        return $this->shopCategoryRepository->getAll();
    }
}
