@extends('layouts.master')

@section('title', 'Типы опции')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Опции товара</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/products">Продукты</a></li>
                        <li class="breadcrumb-item active"><a href="/products/option_types">Типы опции</a></li>
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
                        <div class="col-sm-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <form method="GET" action="{{ url('/products/option_types') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" name="search" placeholder="Поиск..." value="{{ request('search') }}" />
                                        <i class="bx bx-search-alt search-icon"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a href="{{route('option_types.create')}}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">
                                    <i class="mdi mdi-plus mr-1"></i> Добавить
                                </a>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Название на русском</th>
                                <th>Категория</th>
                                <th>Дата добавления</th>
                                @can('edit_users', 'delete_users')
                                    <th>Действии</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($productOptionTypes as $item)
                                <tr>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ $item->id }}</a> </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->name_ru }}</td>
                                    <td>{{ $item->productCategory->name }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    @can('edit_users')
                                        <td>
                                            @include('shared._actions', [
                                                'entity' => 'option_types',
                                                'id' => $item->id,
                                                'actions' => ['delete', 'view', 'edit']
                                            ])
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $productOptionTypes->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
