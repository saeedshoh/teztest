@extends('layouts.master')

@section('title') Cтатистика маркетплейса @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Cтатистика</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Маркетплейс</a></li>
                        <li class="breadcrumb-item active">Cтатистика</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Количество магазинов</p>
                                    <h4 class="mb-0">{{$statics['shopsCount']}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                        <span class="avatar-title">
                                                            <i class="bx bxs-store font-size-24"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Количество товаров</p>
                                    <h4 class="mb-0">{{$statics['productsCount']}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bxl-product-hunt font-size-24"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Количество клиентов</p>
                                    <h4 class="mb-0">{{$statics['clientsCount']}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bx-user-check font-size-24"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Количество заказов (статус: в процессе) </p>
                                    <h4 class="mb-0">{{$statics['ordersCount']}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bx-cart font-size-24"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Объем транзакций</p>
                                    <h4 class="mb-0">TJS {{$statics['ordersSum']}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                        <span class="avatar-title">
                                                            <i class="bx bxs-traffic-barrier font-size-24"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Объем возвратов</p>
                                    <h4 class="mb-0">TJS {{$statics['ordersReturnedSum']}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bxl-product-hunt font-size-24"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Доход компании</p>
                                    <h4 class="mb-0">TJS {{$statics['orderTaxSum']}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bx-up-arrow-alt font-size-24"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Доход магазинов</p>
                                    <h4 class="mb-0">TJS {{$statics['merchantsTax']}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bx-store-alt font-size-24"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Заказы</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>Номер заказа</th>
                                <th>Город</th>
                                <th>Статус</th>
                                <th>Номер телефона</th>
                                <th>Клиент</th>
                                <th>Адрес</th>
                                <th>Сумма</th>
                                <th>Дата доставки</th>
                                <th>Дата создания</th>
                                <th>Действии</th>
                            </tr>
                            <tr>

                                {!! Form::open(['method' => 'GET', 'url' => '/orders', 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'orderSearch'])  !!}
                                <td>
                                    {!! Form::number('id',  request('id'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td style="min-width:180px">
                                    {!! Form::select('city_id', $filters['cities'], request('city_id'), ['class' => 'form-control', 'placeholder' => '', 'onChange'=>'form.submit()']) !!}
                                </td>
                                <td style="min-width:180px">
                                    {!! Form::select('order_status_id', $filters['orderStatuses'], request('order_status_id'), ['class' => 'form-control', 'placeholder' => '', 'onChange'=>'form.submit()']) !!}
                                </td>
                                <td>
                                    {!! Form::number('phone_number_delivery',  request('phone_number_delivery'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)" ]) !!}
                                </td>
                                <td>
                                    {!! Form::text('client_fullname',  request('client_fullname'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)" ]) !!}
                                </td>
                                <td>
                                    {!! Form::text('address',  request('address'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)" ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('total_products_price',  request('total_products_price'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)" ]) !!}
                                </td>
                                <td>
                                    <div class="input-group" id="delivery_date">
                                        <input onChange="form.submit()" name="delivery_date" type="text" class="form-control"
                                               data-date-format="yyyy-mm-dd" data-date-container='#delivery_date' data-provide="datepicker" value="{{request('delivery_date')}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group" id="created_at">
                                        <input onChange="form.submit()" name="created_at" type="text" class="form-control"
                                               data-date-format="yyyy-mm-dd" data-date-container='#created_at' data-provide="datepicker" value="{{request('created_at')}}">
                                    </div>
                                </td>
                                {!! Form::close() !!}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->city->name }}</td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-{{$order->orderStatus->icon_name}} font-size-12">
                                            {{ $order->orderStatus->name }}
                                        </span>
                                    </td>
                                    <td>{{ $order->phone_number_delivery }}</td>
                                    <td>{{ $order->client->name }}</td>
                                    <td>{{ $order->address}}</td>
                                    <td>{{ $order->total_products_price }} TJS</td>
                                    <td>{{ $order->delivery_date->format('d-m-Y') }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y H:m:s') }}</td>

                                    <td>{!! Html::link("/orders/{$order->id}",'Подробнее', ['class' => 'btn btn-primary btn-sm btn-rounded waves-effect waves-light']) !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectSubmitForm(e){
            if(e.keyCode === 13){
                document.getElementById("orderSearch").submit();
            }
        }
    </script>
@endsection

