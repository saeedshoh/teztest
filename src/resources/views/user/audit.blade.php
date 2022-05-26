@extends('layouts.master')

@section('title') Dashboard @endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">История пользователя: id {{request()->route('user')['id']}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Каталог</a></li>
                        <li class="breadcrumb-item active">Категории</li>
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
                                <th>Имя</th>
                                <th>Почта</th>
                                <th>Пароль</th>
                                <th>Фото URI</th>
                                <th>Действия</th>
                                <th>Пользователь</th>
                                <th>Дата</th>
                                <th>User Agent</th>
                                <th>Ip address</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($audits as $audit)
                                <tr>
                                    <td>@include('audit._attribute', ['attribute' => 'name'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'email'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'password'])</td>
                                    <td>@include('audit._attribute', ['attribute' => 'profile_photo_path'])</td>
                                    <td>{{ $audit->event === 'updated' ? 'Изменено' : 'Создано' }}</td>
                                    <td><a href="/users/{{$audit->user->id}}" target="_blank">{{ $audit->user->name }}</a> </td>
                                    <td>{{ $audit->created_at }}</td>
                                    <td>{{ $audit->user_agent }}</td>
                                    <td>{{ $audit->ip_address }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $audits->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
