@extends('layouts.master')

@section('title') Создать категорию @endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    @if(Request::get('id') && Request::get('name'))
                        <h4 class="card-title">Создать подкатегории для категории {{Request::get('name')}}</h4>
                    @endif
                    <form action = "{{ route('categories.store') }}" method = "POST" enctype = "multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Название">
                                    @if(Request::get('id') && Request::get('name'))
                                        <input type="hidden" name="parent_id" value="{{Request::get('id')}}">
                                    @endif
                                    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="icon">
                                        <label class="custom-file-label" for="customFile">Выбрать файл png</label>
                                    </div>
                                    {!! $errors->first('icon', '<p class="help-block text-danger">:message</p>') !!}
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
