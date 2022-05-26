@extends('layouts.master')

@section('title') Dashboard @endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">История магазина: id {{request()->route('shop')['id']}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Каталог</a></li>
                        <li class="breadcrumb-item active">Категории</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>Название</th>
                                <th>Название компании</th>
                                <th>Номер телефона</th>
                                <th>Действия</th>
                                <th>Пользователь</th>
                                <th>Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($audits as $audit)
                                <tr data-toggle="collapse" data-target="#open{{$loop->index}}" class="accordion-toggle">
                                    <td>@include('audit._attribute', ['attribute' => 'name'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'company_name'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'phone_number'])</td>
                                    <td>{{ $audit->event === 'updated' ? 'Изменено' : 'Создано' }}</td>
                                    <td><a href="/users/{{$audit->user->id}}" target="_blank">{{ $audit->user->name }}</a></td>
                                    <td>{{ $audit->created_at }}</td>
                                </tr>
                                <tr>
                                    <td colspan="12" class="hiddenRow">
                                        <div class="accordian-body collapse" id="open{{$loop->index}}">
                                            <table class="table mb-0 table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Название</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'name'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Категория</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'shop_category_id'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Город</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'city_id'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Адрес</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'address'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Описание</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'description'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Номер телефона</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'phone_number'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Название компании</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'company_name'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">ИНН</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'tin'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">SIN</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'sin'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Тип компании</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'company_type'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Название Банка</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'bank_name'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Банк Счет</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'company_account_number'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Цена доставки</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'delivery_price'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Тезсум Id</th>
                                                        <td>@include('audit._attribute', ['attribute' => 'tezsum_site_id'])</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Действия</th>
                                                        <td>{{ $audit->event === 'updated' ? 'Изменено' : 'Создано' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Пользователь</th>
                                                        <td><a href="/users/{{$audit->user->id}}" target="_blank">{{ $audit->user->name }}</a></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">USER AGENT</th>
                                                        <td>{{$audit->user_agent}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">IP ADDRESS</th>
                                                        <td>{{ $audit->ip_address }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                </div>
            </div>
        </div>

    </div>
<!--    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>Название</th>
                                <th>Категория</th>
                                <th>Город</th>
                                <th>Адрес</th>
                                <th>Описание</th>
                                <th>Номер телефона</th>
                                <th>Название компании</th>
                                <th>ИНН</th>
                                <th>SIN</th>
                                <th>Тип компании</th>
                                <th>Название Банка</th>
                                <th>Банк Счет</th>
                                <th>Цена доставки</th>
                                <th>Тезсум Id</th>
                                <th>Действия</th>
                                <th>Пользователь</th>
                                <th>Дата</th>
                                <th>User Agent</th>
                                <th>Ip address</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($audits as $audit)
                                <tr>
                                    <td>@include('audit._attribute', ['attribute' => 'name'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'shop_category_id'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'city_id'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'address'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'description'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'phone_number'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'company_name'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'tin'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'sin'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'company_type'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'bank_name'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'company_account_number'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'delivery_price'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'tezsum_site_id'])</td>
                                    <td>{{ $audit->event === 'updated' ? 'Изменено' : 'Создано' }}</td>
                                    <td><a href="/users/{{$audit->user->id}}" target="_blank">{{ $audit->user->name }}</a> </td>
                                    <td>{{ $audit->created_at }}</td>
                                    <td>{{ $audit->user_agent }}</td>
                                    <td>{{ $audit->ip_address }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $audits->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>-->
@endsection
