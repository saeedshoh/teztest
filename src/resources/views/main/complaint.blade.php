@extends('layouts.master')

@section('title') Все категории @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Обратная связь</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item active"><a href="/complaints">Обратная связь</a></li>
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
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Тема</th>
                                <th>Имя клиента</th>
                                <th>Телефон</th>
                                <th>Почта</th>
                                <th>Дата добавление</th>
                                <th>Действии</th>
                            </tr>
                            {!! Form::open(['method' => 'GET', 'url' => '/complaints', 'class' => 'form-inline my-2 my-lg-0 float-right', 'id' => 'orderSearch'])  !!}
                            <tr>
                                <td>
                                    {!! Form::number('id',  request('id'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('subject',  request('subject'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('name',  request('name'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('phone_number',  request('phone_number'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
                                </td>
                                <td>
                                    {!! Form::text('email',  request('email'), ['class' => 'form-control', 'onkeypress' => "selectSubmitForm(event)"]) !!}
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
                            @foreach($complaints as $complaint)
                                <tr>
                                    <th scope="row">{{$complaint->id}}</th>
                                    <td>{{$complaint->subject}}</td>
                                    <td>{{$complaint->client->name}}</td>
                                    <td>{{$complaint->client->phone_number}}</td>
                                    <td>{{$complaint->email}}</td>
                                    <td>{{$complaint->created_at}}</td>
                                    <td>
                                        <a href="/complaints/{{$complaint->id}}" class="mr-3 text-primary"
                                           data-toggle="tooltip" data-placement="top"  data-original-title="View">
                                            <i class="mdi mdi-eye font-size-18"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $complaints->links('vendor.pagination.custom') }}
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
