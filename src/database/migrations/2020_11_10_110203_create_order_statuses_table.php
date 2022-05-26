<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        $this->seedData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_statuses');
    }

    public function seedData()
    {
        DB::table('order_statuses')->insert([
            'name' => 'Новый',
            'description' => 'Обо всех заказах со статусом “Новый” администратор получает уведомления по почте, что позволяет ему мгновенно связываться с покупателем. Для удобства учета новых заказов, они автоматически попадают во вкладку “Новые” на панели управления заказами и отображаются в виде списка с сортировкой по дате добавления',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Оплачивается',
            'description' => 'Статус может быть назначен администратором, после отправки клиенту счета для оплаты.',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Оплачен',
            'description' => 'Статус присваивается заказу автоматически, если расчет произведен через платежную систему Деньги Online. В случае, если товар был доставлен курьером и оплачен наличными, статус может использоваться как отчетный;',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'В доставку',
            'description' => 'Администратор присваивает заказам этот статус при составлении листа доставки. Лист передается курьеру вместе с товарами.',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Доставляется',
            'description' => 'Статус присваивается заказам, переданным курьеру. Заказ может сохранять этот статус достаточно долго, в зависимости от того как далеко находится клиент;',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Готов',
            'description' => 'Cтатус присваивается заказу, если товар доставлен, оплачен, и его можно отправить в архив. Заказы с этим статусом нужны вам только для внутреннего учета.',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Отменен',
            'description' => 'Администратор присваивает заказу такой статус, если клиент по каким-то причинам отказался от заказа;',
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Возврат',
            'description' => 'Администратор присваивает заказу такой статус, если клиент по каким-то причинам вернул товар.',
        ]);
    }
}
