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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>Название</th>
                                <th>Магазин</th>
                                <th>Цена</th>
                                <th>Категория</th>
                                <th>Кол-заказов</th>
                                <th>Кол-просмотров</th>
                                <th>Статус</th>
                                <th>Действии</th>
                            </tr>
                            <tr>
                                {!! Form::open(['method' => 'GET', 'url' => '/products', 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'productSearch'])  !!}
                                <td>
                                    {!! Form::text('search_text',  request('search_text'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)", "placeholder"=>"Поиск..."]) !!}
                                </td>
                                <td>
                                    <select class="form-control select2" name="shop_id" onchange="form.submit()">
                                        <option selected value="0">Выбрать ...</option>
                                        @foreach($shops as $shop)
                                            <option
                                                value="{{$shop->id}}" {{$shop->id == request('shop_id') ? 'selected' : '' }}>{{$shop->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    {!! Form::text('price',  request('price'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    <select class="form-control" name="product_category_id" onChange="form.submit()">
                                        <option value="" selected></option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}" {{request('product_category_id') == $category['id'] ? 'selected' : '' }}>{{$category['name']}} ({{$category['products_count']}})</option>
                                            @foreach($category['sub_category'] as $sub)
                                                <option value="{{$sub['id']}}" {{request('product_category_id') == $sub['id'] ? 'selected' : '' }}>-{{$sub['name']}} ({{$sub['products_count']}})</option>
                                                @foreach($sub['sub_category'] as $subsub)
                                                    <option value="{{$subsub['id']}}" {{request('product_category_id') == $subsub['id'] ? 'selected' : '' }}>--{{$subsub['name']}} ({{$subsub['products_count']}})</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    {!! Form::select('product_status', $filters['productStatuses'], request('product_status'), ['class' => 'form-control', 'placeholder' => '', 'onChange'=>'form.submit()']) !!}
                                </td>
                                {!! Form::close() !!}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td style="white-space: revert; max-width: 300px;">
                                        <img src="{{$product->productMedia->first()['file_uri'] ?? '/assets/images/no-image.svg'}}" class="img-thumbnail rounded-circle" style="height: 70px">
                                         <span >{{$product->title}}</span>
                                    </td>
                                    <td><a href="/shops/{{$product->shop->id ?? null }}" target="_blank">{{ $product->shop->name ?? null }}</a> </td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->productCategory->name }}</td>
                                    <td>{{ $product->order_products_count }}</td>
                                    <td>{{ $product->view_count }}</td>
                                    <td>{{ $filters['productStatuses'][$product->status] }}</td>
                                    <td>
                                        @can('edit_products')
                                            @include('shared._actions', [
                                               'entity' => 'products',
                                               'id' => $product->id,
                                               'actions' => ['delete', 'edit']
                                            ])
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectSubmitForm(e){
            if(e.keyCode === 13){
                document.getElementById("productSearch").submit();
            }
        }
    </script>
@endsection
