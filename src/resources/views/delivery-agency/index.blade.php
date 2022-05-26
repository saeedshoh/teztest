@extends('layouts.master')

@section('title', 'Службы доставки')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Службы доставики</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/delivery_agencies">Службы доставки</a></li>
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
                                <form method="GET" action="{{ url('/delivery_agencies') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" name="search" placeholder="Поиск..." value="{{ request('search') }}" />
                                        <i class="bx bx-search-alt search-icon"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a href="{{route('delivery_agencies.create')}}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">
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
                                <th>Номер телефона</th>
                                <th>Логин</th>
                                <th>Статус</th>
                                <th>Дата добавления</th>
                                @can('edit_users', 'delete_users')
                                    <th>Действии</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deliveryAgencies as $item)
                                <tr>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ $item->id }}</a> </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td>{{ $item->user->email }}</td>
                                    <td>
                                        @if($item->status == 'ACTIVE')
                                            <span class="badge badge-pill badge-soft-success font-size-12">Активный</span>
                                        @else
                                            <span class="badge badge-pill badge-soft-danger font-size-12">Заблокирован</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->toFormattedDateString() }}</td>
                                    @can('edit_users')
                                        <td>
                                            @include('shared._actions', [
                                                'entity' => 'delivery_agencies',
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
                    {{ $deliveryAgencies->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
