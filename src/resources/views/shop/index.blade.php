@extends('layouts.master')

@section('title') Магазины @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Магазины</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Shops</li>
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
                                <th>Название</th>
                                <th>Кол-продуктов</th>
                                <th>Кол-заказов</th>
                                <th>Кол-скидок</th>
                                <th>Кол-подписок</th>
                                <th>Категория</th>
                                <th>Статус</th>
                                <th>Действии</th>
                            </tr>
                            <tr>
                                {!! Form::open(['method' => 'GET', 'url' => '/shops', 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'shopSearch'])  !!}
                                <td>
                                    {!! Form::text('search_text',  request('search_text'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)", "placeholder"=>"Поиск..."]) !!}
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    {!! Form::select('shop_status_id', $filters['shopStatuses'], request('shop_status_id'), ['class' => 'form-control', 'placeholder' => '', 'onChange'=>'form.submit()']) !!}
                                </td>
                                {!! Form::close() !!}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shops as $shop)
                                <tr>
                                    <td>
                                        @if($shop->logo)
                                            <img src="{{$shop->logoLink}}" class="img-thumbnail rounded-circle"
                                                 style="height: 70px" />
                                        @endif
                                        <span> {{ $shop->name }}</span>
                                    </td>
                                    <td>{{ $shop->products_count }}</td>
                                    <td>{{ $shop->orders_count }}</td>
                                    <td>{{ $shop->products_with_sale_count }}</td>
                                    <td>{{ $shop->client_shops_subscriptions_count }}</td>
                                    <td>{{ $shop->shopCategory->name }}</td>
                                    <td>{{ $filters['shopStatuses'][$shop->status] }}</td>

                                    <td>
                                        @include('shared._actions', [
                                           'entity' => 'shops',
                                           'id' => $shop->id,
                                           'actions' => ['view','edit', 'audit']
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $shops->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectSubmitForm(e) {
            if (e.keyCode === 13) {
                document.getElementById("orderSearch").submit();
            }
        }
    </script>
@endsection

