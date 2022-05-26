@extends('layouts.master')
@section('title', $shop->name)
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Магазины</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/shops">Магазины</a></li>
                        <li class="breadcrumb-item active">{{$shop->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-soft-primary">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Добро пожаловать назад!</h5>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="/assets/images/profile-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                @if($shop->logo)
                                    <img src="{{$shop->logoLink}}" class="img-thumbnail rounded-circle">
                                @else
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                        {{substr($shop->name, 0, 1)}}
                                    </span>
                                @endif
                            </div>
                            <h5 class="font-size-15 text-truncate">{{$shop->name}}</h5>
                            <p class="text-muted mb-0 text-truncate">{{$shop->shopCategory->name}}</p>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{$productCount}}</h5>
                                        <p class="text-muted mb-0">Продукты</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{$tezsumBalance}} TJS</h5>
                                        <p class="text-muted mb-0">Баланс @if(auth()->user()->shop_id == $shop->id)<a
                                                href="/shops/transfers">Трансфер</a>@endif</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Описание</h4>
                    <p class="text-muted mb-4">{{$shop->description}}</p>

                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">Город :</th>
                                <td>{{$shop->city->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Номер телефона :</th>
                                <td>{{$shop->phone_number}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Адрес :</th>
                                <td>{{$shop->address}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Имя Организации :</th>
                                <td>{{$shop->company_name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">TIN :</th>
                                <td>{{$shop->tin}}</td>
                            </tr>
                            <tr>
                                <th scope="row">SIN :</th>
                                <td>{{$shop->sin}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Счет :</th>
                                <td>{{$shop->company_account_number}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Банк:</th>
                                <td>{{$shop->bank_name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">БИК :</th>
                                <td>{{$shop->bik}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Банковский счет :</th>
                                <td>{{$shop->bank_account_number}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Цена доставки :</th>
                                <td>{{$shop->delivery_price}} TJS</td>
                            </tr>
                            <tr>
                                <th scope="row">Срок доставки :</th>
                                <td>{{$shop->estimated_delivery_time}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Тезсум Мерчант ID :</th>
                                <td>{{$shop->tezsum_site_id}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Файлы</h4>
                    @can('upload_files_shops')
                        <form action="/shops/upload_files" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                @csrf
                                <div class="col-12">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="shop_files[]"
                                               multiple onchange="form.submit(); this.disabled = true">
                                        <label class="custom-file-label" for="customFile">Выбрать файл</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endcan
                    <div class="table-responsive">
                        <table class="table table-nowrap table-centered table-hover mb-0">
                            <tbody>
                            @foreach($shop->shopMedia as $media)
                                <tr>
                                    <td style="width: 45px;">
                                        <div class="avatar-sm">
                                            <span
                                                class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                                <i class="bx bxs-file-doc"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1">
                                            <a target="_blank" href="{{$media->file_uri}}"
                                               class="text-dark">{{$media->title}}</a>
                                        </h5>
                                        <small>{{$media->created_at}}</small>
                                    </td>

                                    <td>
                                        <a href="{{$media->file_uri}}" class="mr-3 text-primary"
                                           download="{{$media->file_uri}}">
                                            <i class="mdi mdi-download font-size-18"></i>
                                        </a>
                                        @can('remove_files_shops')
                                            {!! Form::open(['method' => 'delete', 'url' => "/shops/delete_file/{$media->id}", 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to delete it?")']) !!}
                                            <button type="submit"
                                                    class="text-danger"
                                                    style="border: none; background: transparent; padding: 0;">
                                                <i class="mdi mdi-close font-size-18"></i>
                                            </button>
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Продукты</p>
                                    <h4 class="mb-0">{{$productCount}}</h4>
                                </div>

                                <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-check-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Заказы</p>
                                    <h4 class="mb-0">{{$orders->total()}}</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-hourglass font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Статус</p>
                                    <h4 class="mb-0">
                                        {{ $filters['shopStatuses'][$shop->status]}}
                                        @role('moderator|admin')
                                        <button type="button" class="btn btn-sm btn-primary waves-effect waves-light"
                                                data-bs-toggle="modal"
                                                data-bs-target="#statusModal">Статусы
                                        </button>
                                        @endrole
                                    </h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-cake font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Заказы</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-hover mb-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Город</th>
                                <th scope="col">Клиент</th>
                                <th scope="col">Номер телефона</th>
                                <th scope="col">Дата доставки</th>
                            </tr>
                            <tr>

                                {!! Form::open(['method' => 'GET', 'url' => "/shops/my_shop", 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'orderSearch'])  !!}
                                <td>
                                    {!! Form::number('id',  request('id'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::select('order_status_id', $filters['orderStatuses'], request('order_status_id'), ['class' => 'form-control', 'placeholder' => '', 'onChange'=>'form.submit()']) !!}
                                </td>
                                <td>
                                    {!! Form::select('city_id', $filters['cities'], request('city_id'), ['class' => 'form-control', 'placeholder' => '', 'onChange'=>'form.submit()']) !!}
                                </td>
                                <td>
                                    {!! Form::text('client_fullname',  request('client_fullname'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::tel('phone_number_delivery',  request('phone_number_delivery'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    <div class="input-group" id="datepicker1">
                                        <input onChange="form.submit()" name="delivery_date" type="text" class="form-control"
                                               data-date-format="yyyy-mm-dd" data-date-container='#datepicker1' data-provide="datepicker">
                                    </div>
                                </td>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <span
                                            class="badge badge-pill badge-soft-{{$order->orderStatus->icon_name}} font-size-12">
                                            {{ $order->orderStatus->name }}
                                        </span>
                                    </td>
                                    <td>{{ $order->city->name }}</td>
                                    <td>{{ $order->client->name }}</td>
                                    <td>{{ $order->phone_number_delivery }}</td>
                                    <td>{{ $order->delivery_date }}</td>

                                    <td>{!! Html::link("/orders/{$order->id}",'Подробнее', ['class' => 'btn btn-primary btn-sm btn-rounded waves-effect waves-light']) !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links('vendor.pagination.custom') }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Statuses modal -->
    <div class="modal fade" id="statusModal" aria-hidden="true" aria-labelledby="..." tabIndex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Статусы</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ url('/shops/change_status/' . $shop->id) }}" class="form-horizontal">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <div class="mt-4">
                                    @if($shop->status != 'ACTIVE')
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="status" value="ACTIVE"
                                                   id="ACTIVE" checked>
                                            <label class="form-check-label" for="ACTIVE">
                                                Активный
                                            </label>
                                        </div>
                                    @endif
                                    @if($shop->status != 'INVISIBLE')
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="status" value="INVISIBLE"
                                                   id="INVISIBLE">
                                            <label class="form-check-label" for="INVISIBLE">
                                                Скрыть
                                            </label>
                                        </div>
                                    @endif
                                    @if($shop->status != 'INACTIVE')
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="status" value="INACTIVE"
                                                   id="INACTIVE">
                                            <label class="form-check-label" for="INACTIVE">
                                                Деактивировать
                                            </label>
                                        </div>
                                    @endif
                                    <button class="btn btn-primary" type="submit">
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- Toogle to second dialog -->
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                        Закрыть
                    </button>
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

