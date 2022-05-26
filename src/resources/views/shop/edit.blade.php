@extends('layouts.master')
@section('title', 'Изменить магазин')
@section('title') Dashboard @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Shops</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item">Shops</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ url('/shops/' . $shop->id) }}" class="form-horizontal" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @include ('shop.form', ['formMode' => 'edit'])
            </form>
        </div>
    </div>

@endsection
