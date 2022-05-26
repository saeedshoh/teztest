<?php

use App\Modules\Orders\Models\OrderStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$this->call([
            OrderStatusesSeeder::class,
        ]);*/
        OrderStatus::truncate();

        $statusInProcess = new OrderStatus();
        $statusInProcess->id = 1;
        $statusInProcess->name = 'В процессе';
        $statusInProcess->description = 'В процессе';
        $statusInProcess->is_active = 1;
        $statusInProcess->icon_name = 'primary';
        $statusInProcess->save();

        $statusSent = new OrderStatus();
        $statusSent->id = 2;
        $statusSent->name = 'Отправлено';
        $statusSent->is_active = 1;
        $statusSent->icon_name = 'warning';
        $statusSent->description = 'Отправлено';
        $statusSent->save();

        $statusApproved = new OrderStatus();
        $statusApproved->id = 3;
        $statusApproved->name = 'Выполнено';
        $statusApproved->is_active = 1;
        $statusApproved->icon_name = 'success';
        $statusApproved->description = 'Выполнено';
        $statusApproved->save();

        $statusReturn = new OrderStatus();
        $statusReturn->id = 4;
        $statusReturn->name = 'Возврат';
        $statusReturn->is_active = 1;
        $statusReturn->icon_name = 'danger';
        $statusReturn->description = 'Возврат';
        $statusReturn->save();

        $statusNotCompleted = new OrderStatus();
        $statusNotCompleted->id = 5;
        $statusNotCompleted->name = 'Не Завершено';
        $statusNotCompleted->is_active = 1;
        $statusNotCompleted->icon_name = 'secondary';
        $statusNotCompleted->description = 'Не Завершено';
        $statusNotCompleted->save();

        $statusCanceled = new OrderStatus();
        $statusCanceled->id = 6;
        $statusCanceled->name = 'Аннулировано';
        $statusCanceled->is_active = 1;
        $statusCanceled->icon_name = 'secondary';
        $statusCanceled->description = 'Аннулировано';
        $statusCanceled->save();
    }

}
