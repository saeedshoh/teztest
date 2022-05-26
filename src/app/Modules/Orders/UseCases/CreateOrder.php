<?php namespace App\Modules\Orders\UseCases;


use App\Http\Resources\OrderResource;
use App\Modules\Orders\Services\SmsOrder;
use App\Modules\Payments\UseCases\InvoiceCreate;
use App\Modules\Payments\UseCases\PaymentCreate;
use App\Modules\Payments\UseCases\TransactionCreate;
use Cart;

use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderProduct;
use App\Modules\Orders\Services\OrderStatusService;


class CreateOrder
{
    public function createOrderByCart(array $orderData)//: array
    {
        $orderData['order_status_id'] = OrderStatusService::ORDER_STATUS_NOT_COMPLETED;
        $orderData['client_id'] = auth()->id();
        $orderData['uniqid'] = uniqid('order_', true);

        try {
            Cart::session(auth()->id());
            $getClientCart = Cart::getContent();

            $shopIds = $getClientCart->pluck('associatedModel.shop.id')->unique()->toArray();

            /**
             * Create Orders by shops
             */
            foreach ($shopIds as $shopId) {
                $productOrdersByShop = $getClientCart->where('associatedModel.shop.id', $shopId);
                $orderData['shop_id'] = $shopId;
                $orderData['delivery_price'] = $productOrdersByShop->first()->associatedModel->shop->delivery_price;
                $orderData['total_products_price'] = $productOrdersByShop->sum(function ($detail) {
                    return $detail->price * $detail->quantity;
                });

                $createOrder = Order::create($orderData);
                $getCommission = $this->createOrderProduct($productOrdersByShop, $createOrder->id);

                /**
                 * Create Payments
                 */
                $merchantTezsumId = $productOrdersByShop->first()->associatedModel->shop->tezsum_site_id;
                $this->createPayment([
                    'payment_id' => $orderData['payment_id'] ?? '1',
                    'card_id' => $orderData['card_id'] ?? null,
                    'order_id' => $createOrder->id,
                    'delivery_price' => $createOrder->delivery_price,
                    'total_product_price' => $createOrder->total_products_price,
                    'site_id' => $merchantTezsumId,
                    'desc' => $orderData['uniqid'],
                    'commission' => $getCommission
                ]);
            }

            Cart::clear();
        } catch (\Exception $e) {
            \Log::channel('payment')->error($e);
            return ['error' => true, 'message' => $e->getMessage()];
        }

        $query = Order::with(['city', 'orderStatus', 'orderProduct', 'orderProduct.product', 'shop', 'transaction'])
            ->where('client_id', auth()->id())->where('uniqid', $orderData['uniqid']);

        SmsOrder::merchants($orderData['uniqid']);
        SmsOrder::clientInProgress($orderData['uniqid']);

        return OrderResource::collection($query->latest()->simplePaginate())
            ->response()
            ->getData(true);
    }

    private function createOrderProduct($ordersByShop, $orderId)
    {
        $productTaxArray = [];
        foreach ($ordersByShop as $clientCart) {
            $percent = $clientCart->associatedModel->shop->shopCategory->tax;
            $productTax = ($clientCart->price * $percent) / 100;
             OrderProduct::create([
                'name' => $clientCart->name,
                'quantity' => $clientCart->quantity,
                'price' => $clientCart->price,
                'order_id' => $orderId,
                'product_id' => $clientCart->id,
                'attributes' => $clientCart->attributes,
                'product_tax' => $productTax
            ]);

            $productTaxArray[] = $productTax;
        }

        return array_sum($productTaxArray);
    }

    private function createPayment($orderData): bool
    {
        $invoice = new InvoiceCreate();
        $createInvoice = $invoice->createMerchantInvoice($orderData);

        $trans = new TransactionCreate();
        $createTrans = $trans->createClientTransaction($createInvoice['json']['invoice_id']);

        $payment = new PaymentCreate();
        return $payment->createClientPayment($createTrans['json']['trans_id'], $orderData['payment_id'], $orderData['card_id']);
    }

}
