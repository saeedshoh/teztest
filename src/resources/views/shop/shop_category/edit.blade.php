@extends('layouts.master')
@section('title', 'Изменить')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Категории мегазинов</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/shops/shop_categories">Категории мегазинов</a></li>
                        <li class="breadcrumb-item active">{{ $shopCategory->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url('/shops/shop_categories/' . $shopCategory->id) }}" accept-charset="UTF-8" class="form-horizontal">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        @include ('shop.shop_category.form', ['formMode' => 'shop_category.edit'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
