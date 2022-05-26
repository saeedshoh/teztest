@extends('layouts.master')

@section('title') Dashboard @endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Товары</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Каталог</a></li>
                        <li class="breadcrumb-item active">Товары</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Категории</h4>
                </div>
            </div>

        </div>
        <div class="col-lg-9">
            <div class="row mb-3">
                <div class="col-xl-4 col-sm-6">
                    <div class="mt-2">
                        <h5>Все Товары</h5>
                    </div>
                </div>
                <div class="col-lg-8 col-sm-6">
                    <form class="mt-4 mt-sm-0 float-sm-right form-inline">
                        <div class="search-box mr-2">
                            <div class="position-relative">
                                <input type="text" class="form-control border-0" placeholder="Поиск...">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-xl-4 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-img position-relative">
                                    <img src="/assets/images/product/img-1.png" alt="" class="img-fluid mx-auto d-block">
                                </div>
                                <div class="mt-4 text-center">
                                    <h5 class="mb-3 text-truncate">
                                        <a href="/products/{{$product->id}}/show" class="text-dark">{{$product->title}} </a>
                                    </h5>
                                    <h5 class="my-0"><b>{{$product->price}} TJS</b></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
