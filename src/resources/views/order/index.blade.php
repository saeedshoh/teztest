@extends('layouts.master')

@section('title') Заказы @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Заказы</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/orders">Заказы</a></li>
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
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>Номер заказа</th>
                                <th>Город</th>
                                <th>Статус</th>
                                <th>Номер телефона</th>
                                <th>Магазин</th>
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
                                        <select class="form-control select2" name="shop_id" onchange="form.submit()">
                                            <option selected value="0">Выбрать ...</option>
                                            @foreach($shops as $shop)
                                                <option
                                                    value="{{$shop->id}}" {{$shop->id == request('shop_id') ? 'selected' : '' }}>{{$shop->name}}</option>
                                            @endforeach
                                        </select>
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
                                    <td>{{ $order->shop->name ?? 'Магазин удален' }}</td>
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

