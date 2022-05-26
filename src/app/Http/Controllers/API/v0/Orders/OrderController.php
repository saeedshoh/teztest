<?php namespace App\Http\Controllers\API\v0\Orders;


use App\Http\Controllers\API\Controller;

use App\Http\Resources\OrderResource;
use App\Modules\Orders\Models\Order;

use App\Modules\Orders\Repositories\OrderRepository;
use App\Modules\Orders\Requests\CreateOrderCardRequest;
use App\Modules\Orders\Requests\CreateOrderRequest;
use App\Modules\Orders\Services\OrderStatusService;
use App\Modules\Orders\UseCases\CreateOrder;
use App\Modules\Orders\UseCases\OrderStatusModifications;
use App\Modules\Payments\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    private $createOrder;
    private $orderRepository;
    private $orderStatusMod;

    public function __construct(CreateOrder $createOrder, OrderRepository $orderRepository, OrderStatusModifications $orderStatusMod)
    {
        $this->createOrder = $createOrder;
        $this->orderRepository = $orderRepository;
        $this->orderStatusMod = $orderStatusMod;
    }

    /**
     * @OA\Post (
     *     path="/orders",
     *     tags={"Orders"},
     *     operationId="orderAdd",
     *     security={{"bearerAuth":{}}},
     *     summary="Create order data by cart data",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"phone_number_delivery", "city_id", "delivery_agency_id", "delivery_date", "address"},
     *             @OA\Property(property="phone_number_delivery", type="string", example="992915152399"),
     *             @OA\Property(property="city_id", type="integer", example="1"),
     *             @OA\Property(property="delivery_date", type="date", example="2020-12-01"),
     *             @OA\Property(property="address", type="string", example="Шодмони 38"),
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
     *         response="422",
     *         description="Validation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function createOrderByTezsum(CreateOrderRequest $request): JsonResponse
    {
        $validateData = [
            'city_id',
            'phone_number_delivery',
            'delivery_date',
            'address'
        ];

        $createOrder = $this->createOrder->createOrderByCart($request->only($validateData));

        if (isset($createOrder['error']) && $createOrder['error'] == true){
            return $this->setStatusCode(500)->respondWithError(null, $createOrder['message']);
        }

        return $this->respond(['orders' => $createOrder]);
    }

    public function createOrderByCreditCard(CreateOrderCardRequest $request): JsonResponse
    {
        $validateData = [
            'city_id',
            'phone_number_delivery',
            'delivery_date',
            'address',
            'card_id'
        ];

        $requestData = $request->only($validateData);
        $requestData['payment_id'] = Transaction::PAYMENT_CREDIT_CARD;
        $createOrder = $this->createOrder->createOrderByCart($requestData);

        if (isset($createOrder['error']) && $createOrder['error'] == true){
            return $this->setStatusCode(500)->respondWithError(null, $createOrder['message']);
        }

        return $this->respond(['orders' => $createOrder]);
    }

    /**
     * @OA\Post (
     *     path="/orders/confirm",
     *     tags={"Orders"},
     *     operationId="orderConfim",
     *     security={{"bearerAuth":{}}},
     *     summary="Confirm",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Confirm order",
     *         @OA\JsonContent(
     *             required={"order_id"},
     *             @OA\Property(property="order_id", type="integer", example="2"),
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
     *         response="422",
     *         description="Validation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function confirmOrder(Request $request): JsonResponse
    {
        $this->validate($request, [
           'order_id' => [
               'required',
               Rule::exists('orders', 'id')
                   ->where('client_id', auth()->id())
                   ->where('order_status_id', OrderStatusService::ORDER_STATUS_PERFORMED)
           ],
        ]);

        $confirmHold = $this->orderStatusMod->confirmOrder($request);

        if (isset($confirmHold['json']['error'])){
            return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->respondWithError(null, $confirmHold['json']['desc']);
        }

        return $this->respond(null, 'Статус успешно изменен.');
    }

    public function returnOrder(Request $request): JsonResponse
    {
        $this->validate($request, [
            'order_id' => [
                'required',
                Rule::exists('orders', 'id')
                    ->where('client_id', auth()->id())
                    ->where('order_status_id', OrderStatusService::ORDER_STATUS_PERFORMED)
            ],
        ]);

        $returnOrder = $this->orderStatusMod->returnOrder($request);

        if(isset($returnOrder['json']['success'])) {
            return $this->respond(null, 'Статус успешно изменен.');
        }else{
            $this->respond(null, $returnOrder['json']['desc']);
        }

        return $this->respond(null, 'Статус успешно изменен.');
    }

    /**
     * @OA\Get(
     *     path="/orders/client_orders",
     *     tags={"Orders"},
     *     operationId="ordersClient",
     *     @OA\Parameter(
     *         name="order_status_id",
     *         in="query",
     *         required=false
     *     ),
     *     security={{"bearerAuth":{}}},
     *     summary="GET client orders",
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
    public function getOrdersByClientId(): JsonResponse
    {
        return $this->respond([
            'orders' => $this->orderRepository->getOrdersByClientId()
        ]);
    }

    public function getOrderByClientId(int $id): JsonResponse
    {
        $order = Order::where(['client_id' => auth()->id()])->find($id);
        if($order){
            return $this->respond(['order' => new OrderResource($order)]);
        }

        return $this->setStatusCode(404)->respondWithError(null, 'Не найдено');
    }

    /**
     * @OA\Get(
     *     path="/orders/filters",
     *     tags={"Orders"},
     *     operationId="orderFilters",
     *     security={{"bearerAuth":{}}},
     *     summary="GET filters for orders",
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
    public function getOrderFilters(): JsonResponse
    {
        $getFilters = $this->orderRepository->getOrderFilters();

        return $this->respond(['filters' => $getFilters]);
    }
}
