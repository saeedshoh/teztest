@extends('layouts.master')
@section('title', $shopCategory->name)
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
                    <div class="row mb-2">
                        @include('shared._actions', [
                            'entity' => 'shop_categories',
                            'id' => $shopCategory->id,
                            'actions' => ['delete', 'product.edit']
                        ])
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $shopCategory->id }}</td>
                            </tr>
                            <tr>
                                <th> Name</th>
                                <td> {{ $shopCategory->name }} </td>
                            </tr>
                            {{--   <tr>
                                   <th> Parent Id </th>
                                   <td> {{ $shopCategory->parent_id }} </td>
                               </tr>--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
