@extends('layouts.master')
@section('title') {{$product->title}} @endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Товар</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Каталог</a></li>
                        <li class="breadcrumb-item active">Товар</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="product-detai-imgs">
                                <div class="row">
                                    <div class="col-md-2 col-sm-3 col-4">
                                        <div class="nav flex-column nav-pills " id="v-pills-tab" role="tablist"
                                             aria-orientation="vertical">
                                            @foreach($product->productMedia as $media)
                                                <a class="nav-link {{$loop->iteration == 1 ?'show active':''}}"
                                                   id="product-{{$media->id}}-tab"
                                                   data-toggle="pill"
                                                   href="#product-{{$media->id}}"
                                                   role="tab"
                                                   aria-controls="product-{{$media->id}}"
                                                   aria-selected="false">
                                                    <img src="{{$media->file_uri}}"
                                                         class="img-fluid mx-auto d-block rounded">
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            @foreach($product->productMedia as $media)
                                                <div class="tab-pane fade {{$loop->iteration == 1 ?'show active':''}}"
                                                     id="product-{{$media->id}}" role="tabpanel"
                                                     aria-labelledby="product-{{$media->id}}-tab">
                                                    <div>
                                                        <img src="{{$media->file_uri}}"
                                                             class="img-fluid mx-auto d-block">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="mt-4 mt-xl-3">
                                <h4 class="mt-1 mb-3">{{$product->title}}</h4>

                                <h5 class="mb-4">Цена : <b>{{$product->price}} TJS</b></h5>
                                @if($product->is_sale)
                                    <h5 class="mb-4">Скидка : <b>{{$product->sale}} %</b></h5>
                                @endif
                                <p class="text-muted mb-4">{{$product->description}}</p>

                                <div class="mt-5">
                                    <h5 class="mb-3">Доп :</h5>

                                    <div class="table-responsive">
                                        <table class="table mb-0 table-bordered">
                                            <tbody>
                                            <tr>
                                                <th scope="row" style="width: 400px;">Категория</th>
                                                <td>{{$product->productCategory->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Бренд</th>
                                                <td>{{$product->brand->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Количество</th>
                                                <td>{{$product->quantity}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Статус</th>
                                                <td>{{$product->status}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Просмотров</th>
                                                <td>{{$product->view_count}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Добавлено в избранных</th>
                                                <td>{{$product->wishlist_count}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Добавлено в корзину</th>
                                                <td>{{$product->cart_add_count}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end Specifications -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mt-4 mt-xl-3">
                                @if(empty($product->productOptions))
                                    <div class="mt-5">
                                        <h5 class="mb-3">Атрибуты :</h5>
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-bordered">
                                                <tbody>

                                                @foreach($product->productOptions as $option)
                                                    <tr>
                                                        <th scope="row"
                                                            style="width: 400px;">{{$option->productOptionType->name_ru}}</th>
                                                        <td>{{$option->productOptionValue->name_ru}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
