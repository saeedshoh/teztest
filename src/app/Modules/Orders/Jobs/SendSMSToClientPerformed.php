<?php namespace App\Modules\Orders\Jobs;


use App\Modules\Common\Services\SMSCenter;
use App\Modules\Orders\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSMSToClientPerformed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $orderId;

    /**
     * Create a new job instance.
     *
     * @param $orderId
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = Order::with(['shop'])->find($this->orderId);
        SMSCenter::send($order->phone_number_delivery, "Статус Отправлено: Уважаемый абонент Ваш заказ под №{$order->id} был успешно доставлен, спасибо что выбрали сервис Тезмаркет!");
    }
}

