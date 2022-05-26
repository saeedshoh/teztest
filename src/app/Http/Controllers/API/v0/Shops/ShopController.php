<?php namespace App\Http\Controllers\API\v0\Shops;

use App\Http\Resources\ShopResource;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\API\Controller;
use App\Modules\Shops\UseCases\ShopSubscription;
use App\Modules\Shops\Repositories\ShopRepository;
use App\Modules\Shops\Requests\ShopSubscribeRequest;
use App\Modules\Shops\Requests\ShopUnSubscribeRequest;


class ShopController extends Controller
{
    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var ShopSubscription $shopSubscription
     */
    private $shopSubscription;

    public function __construct(ShopRepository $shopRepository, ShopSubscription $shopSubscription)
    {
        $this->shopRepository = $shopRepository;
        $this->shopSubscription = $shopSubscription;
    }

    /**
     * @OA\Get(
     *     path="/shops/",
     *     tags={"Shops"},
     *     operationId="shopAll",
     *     security={{"bearerAuth":{}}},
     *     summary="GET shops",
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
    public function index()
    {
        return response()->json(['shops' => $this->shopRepository->getAll()]);
    }

    /**
     * @OA\Get(
     *     path="/shops/{id}",
     *     tags={"Shops"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true
     *     ),
     *     operationId="shopShow",
     *     security={{"bearerAuth":{}}},
     *     summary="GET shop by id",
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
        $getShop = $this->shopRepository->getShopById($id);
        return $this->setStatusCode($getShop['statusCode'])->respond([
            'shop' => new ShopResource($getShop['shop']),
            'details' => $getShop['details']
        ]);
    }


    /**
     * @OA\Post (
     *     path="/shops/subscriptions",
     *     tags={"Shops"},
     *     operationId="shopSubAdd",
     *     security={{"bearerAuth":{}}},
     *     summary="Subscribe to shop",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"phone_number", "shop_id"},
     *             @OA\Property(property="shop_id", type="string", example="1"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         ),
     *     ),
     * )
     *
     * @param ShopSubscribeRequest $request
     * @return JsonResponse
     */
    public function subscribe(ShopSubscribeRequest $request): JsonResponse
    {
        $subscribe = $this->shopSubscription->subscribe($request->only(['phone_number', 'shop_id']));
        return $this->setStatusCode($subscribe['statusCode'])->respond(['subscribe' => $subscribe['subscribe']]);
    }

    /**
     * @OA\Delete (
     *     path="/shops/subscriptions",
     *     tags={"Shops"},
     *     operationId="shopSubDelete",
     *     security={{"bearerAuth":{}}},
     *     summary="Delete Subscription",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"shop_id"},
     *             @OA\Property(property="shop_id", type="integer", example="1"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         ),
     *     ),
     * )
     *
     * @param ShopUnSubscribeRequest $request
     * @return JsonResponse
     */
    public function unsubscribe(ShopUnSubscribeRequest $request): JsonResponse
    {
        $unsubscribe = $this->shopSubscription->unsubscribe($request->only(['shop_id']));
        return $this->setStatusCode($unsubscribe['statusCode'])->respond(['unsubscribe' => $unsubscribe['subscribe']]);
    }
}
