@extends('layouts.master')
@section('title', 'Создать службу доставки')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Создать службу доставки</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Ecommerce</a></li>
                        <li class="breadcrumb-item"><a href="/delivery_agencies/">Служба доставки</a></li>
                        <li class="breadcrumb-item active">Создать</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url('/delivery_agencies/') }}" accept-charset="UTF-8"
                          class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @include ('delivery-agency.form', ['formMode' => 'create'])
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
