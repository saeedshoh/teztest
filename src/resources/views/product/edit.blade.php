@extends('layouts.master')

@section('title') Изменить товар @endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Изменить: {{$product->title}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/products">Товары</a></li>
                        <li class="breadcrumb-item active">{{$product->title}}</li>
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
                    <a class="nav-link active" id="v-pills-general-tab" data-toggle="pill" href="#v-pills-general"
                       role="tab" aria-controls="v-pills-general" aria-selected="true">
                        <i class="mdi mdi-moon-waning-crescent d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="font-weight-bold mb-4">Основная информация</p>
                    </a>
                    <a class="nav-link" id="v-pills-media-tab" data-toggle="pill" href="#v-pills-media" role="tab"
                       aria-controls="v-pills-media" aria-selected="false">
                        <i class="mdi mdi-moon-last-quarter d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="font-weight-bold mb-4">Галерея</p>
                    </a>
                    <a class="nav-link" id="v-pills-attributes-tab" data-toggle="pill" href="#v-pills-attributes"
                       role="tab" aria-controls="v-pills-attributes" aria-selected="false">
                        <i class="mdi mdi-moon-full d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="font-weight-bold mb-4">Атрибуты</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-10 col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel"
                                 aria-labelledby="v-pills-general-tab">
                                <form method="POST" action="{{ url('/products/' . $product->id) }}" class="form-horizontal">
                                @method('PUT')
                                @csrf
                                    @include('product.parts.basic-inputs', ['formMode' => 'edit'])
                                </form>
                            </div>
                            <div class="tab-pane fade" id="v-pills-media" role="tabpanel"
                                 aria-labelledby="v-pills-media-tab">
                                @include('product.parts.media', ['formMode' => 'edit'])
                            </div>
                            <div class="tab-pane fade" id="v-pills-attributes" role="tabpanel"
                                 aria-labelledby="v-pills-attributes-tab">
                                @include('product.parts.attributes', ['formMode' => 'edit'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-3">

            </div>
            <div class="col-xl-10 col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">
                            @role('moderator|admin')
                            <div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <h1>Текущий статус товара:</h1>
                                        <hr>
                                        <form method="POST" action="{{ url('/products/statuses/denied/' . $product->id) }}" class="form-horizontal">
                                            @method('PUT')
                                            @csrf
                                            <button class="btn btn-danger" type="submit">Отказано</button>
                                        </form>
                                    </div>
                                    <div class="col-xl-6">
                                        <h1 class="text-right">{{$statuses[$product->status]}}</h1>
                                        <hr>
                                        <form method="POST" action="{{ url('/products/statuses/active/' . $product->id) }}" class="form-horizontal">
                                            @method('PUT')
                                            @csrf
                                            <button class="btn btn-success float-right" type="submit">Активный</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            @if(Session::has('tabPos'))
                @switch (Session::get('tabPos'))
                @case(1)
                $('[href="#v-pills-general"]').tab('show');
                @break

                @case(2)
                $('[href="#v-pills-media"]').tab('show');
                @break

                @case(3)
                $('[href="#v-pills-attributes"]').tab('show');
                @break

                @default
                $('[href="#v-pills-attributes"]').tab('show');
                @endswitch

            @endif
        </script>
    @endpush
@endsection


