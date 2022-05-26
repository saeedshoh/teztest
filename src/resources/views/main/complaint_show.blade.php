
@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $complaint->subject }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/complaints]">Обратная связь</a></li>
                        <li class="breadcrumb-item active">{{ $complaint->subject }}</li>
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
                                <td>{{ $complaint->id }}</td>
                            </tr>
                            <tr>
                                <th>Имя</th>
                                <td>
                                    {{ $complaint->client->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>Телефон</th>
                                <td>
                                    {{ $complaint->client->phone_number }}
                                </td>
                            </tr>
                            <tr>
                                <th>Почта</th>
                                <td>
                                    {{ $complaint->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>Сообщение</th>
                                <td>{{ $complaint->message }}</td>
                            </tr>
                            <tr>
                                <th>Дата создание</th>
                                <td>{{ $complaint->created_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <div class="popup-gallery">

                            <div class="row">
                                @foreach($complaint->complaintMedia as $media)
                                    <div class="col-sm-4">
                                        <a class="float-left" href="/media/complaints/{{$media->file_name}}"
                                           title="{{$media->file_name}}">
                                            <div class="img-fluid">
                                                <img src="/media/complaints/{{$media->file_name}}" alt="" width="300">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
