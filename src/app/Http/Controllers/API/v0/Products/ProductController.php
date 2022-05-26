<?php namespace App\Http\Controllers\API\v0\Products;


use App\Modules\Products\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\API\Controller;
use App\Modules\Products\Repositories\ProductRepository;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;


    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @OA\Get(
     *     path="/products/",
     *     tags={"Products"},
     *     operationId="productsAll",
     *     @OA\Parameter(
     *         name="search_text",
     *         in="query",
     *         required=false
     *     ),
     *     @OA\Parameter(
     *         name="brand_id",
     *         in="query",
     *         required=false
     *     ),
     *     @OA\Parameter(
     *         name="product_category_id",
     *         in="query",
     *         required=false
     *     ),
     *     @OA\Parameter(
     *         name="price_min",
     *         in="query",
     *         required=false
     *     ),
     *     @OA\Parameter(
     *         name="price_max",
     *         in="query",
     *         required=false
     *     ),
     *     @OA\Parameter(
     *         name="shop_id",
     *         in="query",
     *         required=false
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false
     *     ),
     *     @OA\Parameter(
     *         name="sorting_field",
     *         in="query",
     *         required=false
     *     ),
     *     @OA\Parameter(
     *         name="sorting_direction",
     *         in="query",
     *         required=false
     *     ),
     *     security={{"bearerAuth":{}}},
     *     summary="GET products",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(['products' => $this->productRepository->getAll($request)]);
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"Products"},
     *     operationId="productGetById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true
     *     ),
     *     security={{"bearerAuth":{}}},
     *     summary="GET product by product id",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getById(int $id): JsonResponse
    {
        $getProduct = $this->productRepository->getProductById($id);
        return $this->setStatusCode($getProduct['statusCode'])->respond($getProduct['product']);
    }

    /**
     * @OA\Get(
     *     path="/products/general_filters",
     *     tags={"Products"},
     *     operationId="productGeneralFilters",
     *     security={{"bearerAuth":{}}},
     *     summary="GET product general filters",
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
    public function getGeneralFilters(): JsonResponse
    {
        $getFilters = $this->productRepository->getGeneralFilters();
        return $this->respond(['filters' => $getFilters]);
    }

    public function getShopFilters(int $shopId): JsonResponse
    {
        $getShopFilters = $this->productRepository->getShopFilters($shopId);
        return $this->respond(['filters' => $getShopFilters]);
    }

}
