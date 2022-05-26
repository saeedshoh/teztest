@extends('layouts.master')
@section('title', 'Тест')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Трансфер</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/shops">Магазины</a></li>
                        <li class="breadcrumb-item"><a href="/shops/{{$shop->id}}">{{$shop->name}}</a></li>
                        <li class="breadcrumb-item active">Трансфер</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Перевод на карту</h4>
                    <form action="/shops/transfer_to_card" method="POST">
                        <div class="row">
                            @csrf
                            <div class="col-12">
                                <div class="form-group">
                                    {!! Form::label('credit_card', 'Кредитная карта'); !!}
                                    {!! Form::input('number', 'credit_card', '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('credit_card', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('amount', 'Сумма'); !!}
                                    {!! Form::input('number', 'amount', '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('amount', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                {!! Form::submit('Вывод', ['class' => 'btn btn-primary mr-1 waves-effect waves-light float-right']) !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Перевод на Банковский счет</h4>
                    <form action="/shops/transfer_to_bank_account" method="POST">
                        <div class="row">
                            @csrf
                            <div class="col-12">
                                <div class="form-group">
                                    {!! Form::label('amount', 'Сумма'); !!}
                                    {!! Form::input('number', 'amount_bank_account', '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('amount_bank_account', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                {!! Form::submit('Вывод', ['class' => 'btn btn-primary mr-1 waves-effect waves-light float-right']) !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Заказы</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover mb-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Сумма</th>
                                <th scope="col">Тип</th>
                                <th scope="col">Номер карты</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ number_format($transaction->amount / 100, 2) }}</td>
                                    <td>{{ $transaction->type == 1 ? 'Карта' : 'Банковский счет'}}</td>
                                    <td>{{ $transaction->credit_card }}</td>
                                    <td>{{ $transaction->status == true ? 'Успешно' : 'Ошибка' }}</td>
                                    <td>{{ $transaction->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $transactions->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
