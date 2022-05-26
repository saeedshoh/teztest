@extends('layouts.master')

@section('title') Редактировать категорию @endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" value="{{$category->name}}">
                                    <input type="hidden" name="parent_id" value="{{$category->parent_id}}">
                                    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1">
                                            @if($category->icon)
                                                <img src="{{$category->IconUri}}" alt="{{$category->name}}" width="30px">
                                            @endif
                                        </div>
                                        <div class="col-md-11">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile"
                                                       name="icon">
                                                <label class="custom-file-label" for="customFile">Выбрать файл
                                                    png</label>
                                            </div>
                                            {!! $errors->first('icon', '<p class="help-block text-danger">:message</p>') !!}
                                        </div>
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
