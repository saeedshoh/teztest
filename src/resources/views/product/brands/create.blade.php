@extends('layouts.master')

@section('title') Создать Бренд @endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Создать бренд</h4>
                    <form action="{{ route('brands.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="description">Название</label>
                                        <input type="text" name="name" class="form-control">
                                        {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Описание</label>
                                        <textarea name="description" class="form-control" id="description" rows="5">
                                        </textarea>
                                        {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 ">
                                <button type="submit" class="btn btn-primary float-right">Создать</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
