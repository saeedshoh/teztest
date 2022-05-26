@extends('layouts.master')
@section('title') #{{$order->id}} @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Заказ #{{ $order->id }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/orders">Заказы</a></li>
                        <li class="breadcrumb-item active">{{ $order->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Номер заказа</th>
                                    <td>{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Магазин</th>
                                    <td>
                                        {{ $order->shop->name }}
                                        <a href="/shops/{{$order->shop->id}}">
                                            <i class='mdi mdi-link font-size-12'></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Клиент</th>
                                    <td>
                                        {{ $order->client->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Город</th>
                                    <td>{{ $order->city->name }}</td>
                                </tr>
                                <tr>
                                    <th>Статус</th>
                                    <td>
                                        <span class="badge badge-pill badge-soft-{{$order->orderStatus->icon_name}} font-size-12">
                                            {{ $order->orderStatus->name }}
                                        </span>
                                        @role('admin')
                                        <hr>
                                        <form method="POST" action="{{ url('/orders/statuses/change_order_status') }}" class="form-horizontal">
                                            <input type="hidden" name="order_id" value="{{$order->id}}">
                                            @csrf
                                            <select class="form-control" name="order_status_id" onChange="form.submit()">
                                                <option selected disabled>Выбрать ...</option>
                                                <option value="2">Отправлено</option>
                                                <option value="3">Выполнено</option>
                                                <option value="4">Подтверждено</option>
                                                <option value="6">Аннулировано</option>
                                                <option value="7">Возврат</option>
                                                <option value="9">Ошибка при оплате</option>
                                            </select>
                                        </form>
                                        @endrole
                                    </td>
                                </tr>
                                <tr>
                                    <th>Дата доставки</th>
                                    <td>{{ $order->delivery_date->format('d-m-Y H:m:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Номер телефона</th>
                                    <td>{{ $order->phone_number_delivery }}</td>
                                </tr>
                                <tr>
                                    <th>Адрес</th>
                                    <td>{{ $order->address }}</td>
                                </tr>
                                <tr>
                                    <th>Итоговая сумма</th>
                                    <td><h2 class="badge badge-soft-info" style="font-size: 100%">{{ $order->delivery_price + $order->total_products_price }} TJS</h2></td>
                                </tr>
                                <tr>
                                    <th>Метод Оплаты</th>
                                    <td>
                                        <?php
                                            use App\Modules\Payments\Models\Transaction;
                                            if (isset($order->transaction->payment_id) && $order->transaction->payment_id === Transaction::PAYMENT_TEZSUM) {
                                                $payment = Transaction::PAYMENT_ARRAY[Transaction::PAYMENT_TEZSUM];
                                            } else {
                                                $payment = Transaction::PAYMENT_ARRAY[Transaction::PAYMENT_CREDIT_CARD];
                                            }
                                        ?>
                                        @if(isset($order->transaction->payment_id))
                                            {{ $payment}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Коментарий к товару</th>
                                    <td>{{ $order->comment }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Название продукта</th>
                                <th>Количество</th>
                                <th>Сумма</th>
                                <th>Дата создание</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderProducts as $orderProduct)
                                <tr>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ $orderProduct->id }}</a> </td>
                                    <td>
                                        {{ $orderProduct->name }}
                                        <a href="/products/{{$orderProduct->product_id}}/show">
                                            <i class='mdi mdi-link font-size-12'></i>
                                        </a>
                                    </td>
                                    <td>{{ $orderProduct->quantity }}</td>
                                    <td>{{ $orderProduct->price }}</td>
                                    <td>{{ $orderProduct->created_at->format('d-m-Y H:m:s') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orderProducts->links('vendor.pagination.custom') }}

                    @if($order->order_status_id == 1 )
                        <div class="row">
                            <div class="col-sm-6">
                                <form method="POST" action="{{ url('/orders/statuses/denied/' . $order->id) }}" class="form-horizontal">
                                    @method('PUT')
                                    @csrf
                                    <button class="btn btn-danger float-left" type="submit">Отменить</button>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <form method="POST" action="{{ url('/orders/statuses/sent/' . $order->id) }}" class="form-horizontal">
                                    @method('PUT')
                                    @csrf
                                    <button class="btn btn-success float-right" type="submit">Подтвердить заказ</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($order->order_status_id == 2 && auth()->user()->shop_id == $order->shop_id)
                        <form method="POST" action="{{ url('/orders/statuses/performed/' . $order->id) }}" class="form-horizontal">
                            @method('PUT')
                            @csrf
                            <button class="btn btn-success float-right" type="submit">Выполнено</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
