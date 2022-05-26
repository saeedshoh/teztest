
@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $user->name }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/users">Пользователи</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
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
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Имя</th>
                                <td>
                                    {{ $user->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>Логин/Почта</th>
                                <td>
                                    {{ $user->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>Статус</th>
                                <td>
                                    @if($user->status == 'ACTIVE')
                                        <span class="badge badge-pill badge-soft-success font-size-12">Активный</span>
                                    @else
                                        <span class="badge badge-pill badge-soft-danger font-size-12">Заблокирован</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Роли</th>
                                <td>
                                    {{ $user->roles->implode('name_ru', ', ') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Дата регистрации</th>
                                <td>{{ $user->created_at->toFormattedDateString() }}</td>
                            </tr>
                            <tr>
                                <th>Дата изменений</th>
                                <td>{{ $user->updated_at->toFormattedDateString() }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
