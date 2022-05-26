@extends('layouts.master')

@section('title', 'Категории магазинов')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Категории магазинов</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/">Магазины</a></li>
                        <li class="breadcrumb-item active">Категории магазинов</li>
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
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a href="{{route('shop_categories.create')}}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">
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
                                <th>Процент</th>
                                <th>Дата добавления</th>
                                @can('edit_users', 'delete_users')
                                    <th>Действии</th>
                                @endcan
                            </tr>
                            {!! Form::open(['method' => 'GET', 'url' => '/shops/shop_categories', 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'shopCategorySearch'])  !!}
                            <tr>
                                <td>
                                    {!! Form::number('id',  request('id'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('name',  request('name'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::email('tax',  request('tax'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
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
                            @foreach($shopCategories as $item)
                                <tr>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ $item->id }}</a> </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->tax }}</td>
                                    <td>{{ $item->created_at}}</td>
                                    <td>
                                        @include('shared._actions', [
                                            'entity' => 'shop_categories',
                                            'id' => $item->id,
                                            'actions' => ['edit']
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $shopCategories->links('vendor.pagination.custom') }}
{{--                    <div class="pagination-wrapper"> {!! $shopCategories->appends(['search' => Request::get('search')])->render() !!} </div>--}}
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectSubmitForm(e){
            if(e.keyCode === 13){
                document.getElementById("shopCategorySearch").submit();
            }
        }
    </script>
@endsection
