<?php


namespace App\Modules\Orders\Services;


use App\Modules\Common\Services\SMSCenter;
use App\Modules\Orders\Models\Order;

class SmsOrder
{
    public static function clientInProgress($orderUniqId)
    {
        $orders = Order::with(['shop'])->where('uniqid', $orderUniqId)->get();
        foreach ($orders as $order){
            SMSCenter::send($order->phone_number_delivery, "Уважаемый абонент Ваш заказ под №{$order->id} успешно был размещен, пожалуйста ожидайте ответа от продавца;");
        }
    }

    public static function clientSent($order)
    {
        SMSCenter::send($order->phone_number_delivery, "Уважаемый абонент Ваш заказ под №{$order->id} только что был отправлен курьером, пожалуйста ожидайте своего заказа;");
    }

    public static function clientPerformed($order)
    {
        SMSCenter::send($order->phone_number_delivery, "Уважаемый абонент Ваш заказ под №{$order->id} был успешно доставлен, спасибо что выбрали сервис Тезмаркет!");
    }

    public static function clientAccepted($order)
    {
        SMSCenter::send($order->phone_number_delivery, "Доставка товара по заказу #{$order->id} успешно подтверждена. Спасибо что выбрали TezMarket");
    }

    public static function clientDenied($order)
    {
        SMSCenter::send($order->phone_number_delivery, "Уважаемый абонент, Ваш заказ под №{$order->id} отменен Вами, ваши денежные средства были возвращены Вам.");
    }

    public static function clientCanceled($order)
    {
        SMSCenter::send($order->phone_number_delivery, "Уважаемый абонент, Ваш заказ под №{$order->id} был аннулирован со стороны продавца, ваши денежные средства были возвращены Вам.");
    }

    public static function clientReturned($order)
    {
        SMSCenter::send($order->phone_number_delivery, "Уважаемый абонент, Ваш заказ под №{$order->id}  был отозван Продавцом по причине возврата, Ваши денежные средства были возвращены Вам");
    }

    public static function merchants($orderUniqId)
    {
        $orders = Order::with(['shop'])->where('uniqid', $orderUniqId)->get();
        foreach ($orders as $order){
           // $url = \App::make('url')->to("/orders/{$order->id}");
            SMSCenter::send($order->shop->phone_number, "Уважаемый продавец к Вам поступил оплаченный заказ №{$order->id}, пожалуйста подтвердите заказ посредством панели управления;");
        }
    }

}
