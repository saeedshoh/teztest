@extends('layouts.master')

@section('title') Редактировать категорию @endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('brands.update', $brand->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="description">Название</label>
                                        <input type="text" name="name" class="form-control" value="{{$brand->name}}">
                                        {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Описание</label>
                                        <textarea name="description" class="form-control" id="description" rows="5">{{$brand->description}}</textarea>
                                        {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 ">
                                <button type="submit" class="btn btn-primary float-right">Изменить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
