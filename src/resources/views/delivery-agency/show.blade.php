@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Служба доставки</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/delivery_agencies">Сулыжбы доставки</a></li>
                        <li class="breadcrumb-item active">{{ $deliveryAgency->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @include('shared._actions', [
                            'entity' => 'delivery_agencies',
                            'id' => $deliveryAgency->id,
                            'actions' => ['delete', 'edit']
                        ])
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $deliveryAgency->id }}</td>
                            </tr>
                            <tr>
                                <th>Название</th>
                                <td>{{ $deliveryAgency->name }} </td>
                            </tr>
                            <tr>
                                <th> Описание</th>
                                <td>{{ $deliveryAgency->description }} </td>
                            </tr>
                            <tr>
                                <th>Номер телефона</th>
                                <td>{{ $deliveryAgency->phone_number }} </td>
                            </tr>
                            <tr>
                                <th>Статус</th>
                                <td>
                                    @if($deliveryAgency->status == 'ACTIVE')
                                        <span class="badge badge-pill badge-soft-success font-size-12">Активный</span>
                                    @else
                                        <span class="badge badge-pill badge-soft-success font-size-12">Заблокирован</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Город</th>
                                <td>{{ $deliveryAgency->city->name }} </td>
                            </tr>
                            <tr>
                                <th>Цена доставки</th>
                                <td>{{ $deliveryAgency->delivery_price }} </td>
                            </tr>
                            <tr>
                                <th>Логин</th>
                                <td>{{ $deliveryAgency->user->email }} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
