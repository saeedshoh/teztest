@extends('layouts.master')
@section('title', 'Создать тип опции')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Создать новую категорию</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/products">Продукты</a></li>
                        <li class="breadcrumb-item"><a href="/products/option_types">Типы опции</a></li>
                        <li class="breadcrumb-item active">Создать</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url('/products/option_types') }}" accept-charset="UTF-8"
                          class="form-horizontal">
                        {{ csrf_field() }}

                        @include ('product.option.type.form', ['formMode' => 'create'])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
