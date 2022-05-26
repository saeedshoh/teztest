@extends('layouts.master')

@section('title', 'Роли и разрешение')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Modal -->
            <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
                <div class="modal-dialog" role="document">
                    {!! Form::open(['method' => 'post']) !!}

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="roleModalLabel">Роль</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- name Form Input -->
                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Role Name']) !!}
                                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            <!-- Submit Form Button -->
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <h3>Роли</h3>
                </div>
                <div class="col-md-7 page-action text-right">
                        <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target="#roleModal"> <i
                                class="glyphicon glyphicon-plus"></i> Создать</a>
                </div>
            </div>


            @forelse ($roles as $role)
                {!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role->id ], 'class' => 'm-b']) !!}

       {{--         @if($role->name === 'Admin')
                    @include('shared._permissions', [
                                  'title' => 'Все разрешении ' . $role->name,
                                  'options' => ['disabled'] ])
                @else--}}
                    @include('shared._permissions', [
                                  'title' => 'Все разрешении ' . $role->name_ru,
                                  'model' => $role ])
                        {!! Form::submit('Обновить', ['class' => 'btn btn-primary']) !!}
              {{--  @endif--}}

                {!! Form::close() !!}

            @empty
                <p>No Roles defined.</p>
            @endforelse

        </div>
    </div>
@endsection
