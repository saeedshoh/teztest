@extends('layouts.master')
@section('title', 'Создать магазин')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Shops</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item">Shops</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            {!! Form::open(['url' => ['/shops/store'], 'enctype'=>"multipart/form-data" ]) !!}
                @include ('shop.form', ['formMode' => 'create'])
            {!! Form::close() !!}
        </div>
    </div>

@endsection
