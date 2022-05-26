<?php namespace App\Modules\Orders\Jobs;


use App\Modules\Common\Services\SMSCenter;
use App\Modules\Orders\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSMSToClientInProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $orderUniqId;
    /**
     * Create a new job instance.
     *
     * @param $orderUniqId
     */
    public function __construct($orderUniqId)
    {
        $this->orderUniqId = $orderUniqId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders = Order::with(['shop'])->where('uniqid', $this->orderUniqId)->get();
        foreach ($orders as $order){
            SMSCenter::send($order->phone_number_delivery, "Статус В процессе: Уважаемый абонент Ваш заказ под №{$order->id} успешно был размещен, пожалуйста ожидайте ответа от продавца;");
        }
    }
}

