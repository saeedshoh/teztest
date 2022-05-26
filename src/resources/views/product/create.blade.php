@extends('layouts.master')

@section('title') Создать товар @endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Создать товар</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/products">Товары</a></li>
                        <li class="breadcrumb-item active">Создать товар</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="checkout-tabs">
        <div class="row">
            <div class="col-xl-2 col-sm-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-shipping-tab" data-toggle="pill" href="#v-pills-shipping" role="tab" aria-controls="v-pills-shipping" aria-selected="true">
                        <i class= "mdi mdi-moon-waning-crescent d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="font-weight-bold mb-4">ШАГ 1: Основная информация</p>
                    </a>
                    <a class="nav-link disabled" id="v-pills-media-tab" data-toggle="pill"  role="tab" aria-controls="v-pills-media" aria-selected="false">
                        <i class= "mdi mdi-moon-last-quarter d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="font-weight-bold mb-4">ШАГ 2: Галерея</p>
                    </a>
                    <a class="nav-link disabled" id="v-pills-attributes-tab"  data-toggle="pill" role="tab" aria-controls="v-pills-attributes" aria-selected="false">
                        <i class= "mdi mdi-moon-full d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="font-weight-bold mb-4">ШАГ 3: Теги</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-10 col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                                {!! Form::open(['url' => route('products.store')]) !!}
                                    @include('product.parts.basic-inputs', ['formMode' => 'create'])
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
