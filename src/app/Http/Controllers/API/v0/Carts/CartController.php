<?php namespace App\Http\Controllers\API\v0\Carts;

use App\Http\Resources\CartResource;
use Cart;
use Illuminate\Http\JsonResponse;

use App\Modules\Cart\UseCases\CartCrud;
use App\Http\Controllers\API\Controller;
use App\Modules\Cart\Requests\CartRequest;
use App\Modules\Cart\Requests\CartDeleteRequest;
use App\Modules\Cart\Repositories\CartRepository;

class CartController extends Controller
{
    private $cartCrud;
    private $cartRepository;

    public function __construct(CartCrud $cartCrud, CartRepository $cartRepository)
    {
        $this->cartCrud = $cartCrud;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @OA\Get(
     *     path="/cart",
     *     tags={"Carts"},
     *     operationId="cartShow",
     *     security={{"bearerAuth":{}}},
     *     summary="GET cart data",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function getBySubscriberId(): JsonResponse
    {
        $cartSession = Cart::session(auth()->id());

        if ($cartSession->getTotalQuantity() == 0){
            return $this->respondWithError(null,'Корзина пуста.');
        }
        $getUniqueShop = $cartSession->getContent()->pluck('associatedModel.shop')->unique();

        return $this->respond([
            'cartContent' => CartResource::collection($cartSession->getContent()),
            'total_delivery_price' => $getUniqueShop->sum('delivery_price'),
            'totalCount' => $cartSession->getTotalQuantity(),
            'totalSum' => (float) $cartSession->getTotal()
        ]);
    }

    /**
     * @OA\Post (
     *     path="/cart",
     *     tags={"Carts"},
     *     operationId="cartAdd",
     *     security={{"bearerAuth":{}}},
     *     summary="Add to cart",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"product_id", "quantity"},
     *             @OA\Property(property="product_id", type="integer", example="1"),
     *             @OA\Property(property="quantity", type="integer", example="8"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not founded",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     *
     * @param CartRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function add(CartRequest $request): JsonResponse
    {
        $cartSession = Cart::session(auth()->id());
        $this->cartCrud->add($request->all());
        $getUniqueShop = $cartSession->getContent()->pluck('associatedModel.shop')->unique();

        return $this->respond([
            'cartContent' => CartResource::collection($cartSession->getContent()),
            'total_delivery_price' => $getUniqueShop->sum('delivery_price'),
            'totalCount' => $cartSession->getTotalQuantity(),
            'totalSum' => (float) $cartSession->getTotal()
        ]);
    }

    /**
     * @OA\Delete (
     *     path="/cart",
     *     tags={"Carts"},
     *     operationId="cartDelete",
     *     security={{"bearerAuth":{}}},
     *     summary="Add cart data by phone number",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"product_id"},
     *             @OA\Property(property="product_id", type="integer", example="1"),
     *             @OA\Property(property="quantity", type="integer", example="1"),
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
     * @param CartDeleteRequest $request
     * @return JsonResponse
     */
    public function delete(CartDeleteRequest $request): JsonResponse
    {
        $cartSession = Cart::session(auth()->id());

        $cartSession->remove($request->product_id);

        if($cartSession->getTotalQuantity() == 0){
            return $this->respond(null,'Успешно удалено. Корзина пуста.');
        }
        $getUniqueShop = $cartSession->getContent()->pluck('associatedModel.shop')->unique();

        return $this->respond([
            'cartContent' => CartResource::collection($cartSession->getContent()),
            'total_delivery_price' => $getUniqueShop->sum('delivery_price'),
            'totalCount' => $cartSession->getTotalQuantity(),
            'totalSum' => (float) $cartSession->getTotal()
        ], 'Успешно удалено');
    }

    /**
     * @OA\Put (
     *     path="/cart/remove_quantity",
     *     tags={"Carts"},
     *     operationId="cartDelete",
     *     security={{"bearerAuth":{}}},
     *     summary="Remove quantity from the cart",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"product_id", "quantity"},
     *             @OA\Property(property="product_id", type="integer", example="1"),
     *             @OA\Property(property="quantity", type="integer", example="1"),
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
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function removeQuantity(CartRequest $request): JsonResponse
    {
        $cartSession = Cart::session(auth()->id());

        Cart::update($request->product_id, ['quantity' => -$request->quantity]);
        $getUniqueShop = $cartSession->getContent()->pluck('associatedModel.shop')->unique();

        return $this->respond([
            'cartContent' => CartResource::collection($cartSession->getContent()),
            'total_delivery_price' => $getUniqueShop->sum('delivery_price'),
            'totalCount' => $cartSession->getTotalQuantity(),
            'totalSum' => (float) $cartSession->getTotal()
        ], 'Успешно удалено');
    }

}
