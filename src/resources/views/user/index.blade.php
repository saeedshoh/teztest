@extends('layouts.master')

@section('title', 'Пользователи')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Пользователи</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Пользователи</li>
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
                        <div class="col-sm-8">
                            <a href="/users/create" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">
                                <i class="mdi mdi-plus mr-1"></i> Добавить
                            </a>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th>id</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Роли</th>
                                <th>Статус</th>
                                <th>Дата создание</th>
                                @can('edit_users', 'delete_users')
                                <th>Действии</th>
                                @endcan
                            </tr>
                            {!! Form::open(['method' => 'GET', 'url' => '/users', 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'orderSearch'])  !!}
                            <tr>
                                <td>
                                    {!! Form::number('id',  request('id'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('name',  request('name'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::email('email',  request('email'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                </td>
                                <td style="min-width:180px">
                                    {!! Form::select('status', $statuses, request('status'), ['class' => 'form-control', 'placeholder' => '', 'onChange'=>'form.submit()']) !!}
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
                            @foreach($result as $item)
                            <tr>
                                <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ $item->id }}</a> </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->roles->implode('name_ru', ', ') }}</td>
                                <td>
                                    @if($item->status == 'ACTIVE')
                                        <span class="badge badge-pill badge-soft-success font-size-12">Активный</span>
                                    @else
                                        <span class="badge badge-pill badge-soft-danger font-size-12">Заблокирован</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at}}</td>
                                @can('edit_users')
                                    <td class="text-center">
                                        @include('shared._actions', [
                                            'entity' => 'users',
                                            'id' => $item->id,
                                            'actions' => ['delete', 'view', 'audit', 'edit']
                                        ])
                                    </td>
                                @endcan
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $result->links('vendor.pagination.custom') }}
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
