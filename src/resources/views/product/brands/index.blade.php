@extends('layouts.master')

@section('title') Все категории @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Бренды</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/products">Продукты</a></li>
                        <li class="breadcrumb-item active"><a href="/products/brands">Бренды</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a class="btn btn-primary waves-effect waves-light float-right"
                                   href="{{route('brands.create')}}">Создать</a>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Количество товаров</th>
                                <th>Дата добавление</th>
                                <th>Действии</th>
                            </tr>
                            {!! Form::open(['method' => 'GET', 'url' => '/products/brands', 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'orderSearch'])  !!}
                            <tr>
                                <td>
                                    {!! Form::number('id',  request('id'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('name',  request('name'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::email('email',  request('description'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                </td>
                                <td>
                                    <div class="input-group" id="created_at">
                                        <input onChange="form.submit()" name="created_at" type="text" class="form-control"
                                               data-date-format="yyyy-mm-dd" data-date-container='#created_at' data-provide="datepicker" value="{{request('created_at')}}">
                                    </div>
                                </td>
                            </tr>
                            {!! Form::close() !!}
                            </thead>
                            <tbody>
                            @foreach($brands as $brand)
                                <tr>
                                    <th scope="row">{{$brand->id}}</th>
                                    <td>{{$brand->name}}</td>
                                    <td>{{$brand->description}}</td>
                                    <td>{{$brand->products_count}}</td>
                                    <td>{{$brand->created_at}}</td>
                                    <td>
                                        @include('shared._actions', [
                                           'entity' => 'brands',
                                           'id' => $brand->id,
                                           'actions' => ['delete', 'edit']
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $brands->links('vendor.pagination.custom') }}
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
