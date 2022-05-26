
@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Товары</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/orders">Заказы</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Названиме</th>
                                <th>Цена</th>
                                <th>Категория</th>
                                <th>Статус</th>
                                <th>Магазин</th>
                                <th>Дата создания</th>
                                <th>Дата изменения</th>
                                <th>Действии</th>
                            </tr>
                            <tr>

                                {!! Form::open(['method' => 'GET', 'url' => '/products/table', 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'orderSearch'])  !!}
                                <td>
                                    {!! Form::number('id',  request('id'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('title',  request('title'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('price', request('price'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    <select class="form-control" name="product_category_id" onChange="form.submit()">
                                        <option value="" selected></option>
                                        @foreach($filters['productCategories'] as $category)
                                            <option value="{{$category['id']}}" {{request('product_category_id') == $category['id'] ? 'selected' : '' }}>{{$category['name']}}</option>
                                            @foreach($category['sub_category'] as $sub)
                                                <option value="{{$sub['id']}}" {{request('product_category_id') == $sub['id'] ? 'selected' : '' }}>-{{$sub['name']}}</option>
                                                @foreach($sub['sub_category'] as $subsub)
                                                    <option value="{{$subsub['id']}}" {{request('product_category_id') == $subsub['id'] ? 'selected' : '' }}>--{{$subsub['name']}}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    {!! Form::select('status', $filters['productStatuses'], request('status'), ['class' => 'form-control', 'placeholder' => '', 'onChange'=>'form.submit()']) !!}
                                </td>
                                {!! Form::close() !!}
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->productCategory->name }}</td>
                                    <td>{{ $filters['productStatuses'][$product->status] }}</td>
                                    <td><a href="/shops/{{$product->shop->id ?? null }}" target="_blank">{{ $product->shop->name ?? null }}</a> </td>
                                    <td>{{ $product->created_at }}</td>
                                    <td>{{ $product->updated_at}}</td>
                                        <td>
                                            @include('shared._actions', [
                                                'entity' => 'products',
                                                'id' => $product->id,
                                                'actions' => ['delete', 'view', 'edit']
                                            ])
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
                document.getElementById("orderSearch").submit();
            }
        }
    </script>
@endsection

