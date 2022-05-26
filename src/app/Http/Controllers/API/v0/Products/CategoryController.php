<?php namespace App\Http\Controllers\API\v0\Products;


use App\Modules\Products\Models\ProductCategory;
use App\Modules\Products\Services\ProductCategoryService;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\API\Controller;
use App\Modules\Products\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;


    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @OA\Get(
     *     path="/products/categories/",
     *     tags={"Products"},
     *     operationId="productsCategoriesShow",
     *     security={{"bearerAuth":{}}},
     *     summary="GET products' categories",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     *
     * @return JsonResponse
     */
    public function getAll()
    {
        return $this->categoryRepository->getAllCategories();
    }

    /**
     * @OA\Get(
     *     path="/products/categories/shop/{shop_id}",
     *     tags={"Products"},
     *     operationId="productsShopCategories",
     *     @OA\Parameter(
     *         name="shop_id",
     *         in="path",
     *         required=true
     *     ),
     *     security={{"bearerAuth":{}}},
     *     summary="GET shop categories",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     *
     * @param int $shopId
     * @return JsonResponse
     */
    public function getShopCategories(int $shopId)
    {
        $getShopCategories = $this->categoryRepository->getCategoriesByShopId($shopId);

        return response()->json(['shop_categories' => $getShopCategories]);
    }

}
