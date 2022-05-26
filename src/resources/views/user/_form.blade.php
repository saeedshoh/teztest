<!-- Name Form Input -->
<div class="form-group @if ($errors->has('name')) has-error @endif">
    {!! Form::label('name', 'Имя') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Имя']) !!}
    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
</div>

<!-- email Form Input -->
<div class="form-group @if ($errors->has('email')) has-error @endif">
    {!! Form::label('email', 'Почта.Логин') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Почта']) !!}
    {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
</div>

<!-- password Form Input -->
<div class="form-group @if ($errors->has('password')) has-error @endif">
    {!! Form::label('password', 'Пароль') !!}
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Пароль']) !!}
    {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
</div>

<!-- Roles Form Input -->
<div class="form-group @if ($errors->has('roles')) has-error @endif">
    {!! Form::label('roles[]', 'Роль') !!}
    {!! Form::select('roles[]', $roles, isset($user) ? $user->roles->pluck('id')->toArray() : null,  ['class' => 'form-control']) !!}
    {!! $errors->first('roles[]', '<p class="help-block text-danger">:message</p>') !!}
</div>

<!-- Permissions -->
{{--@if(isset($user))
    @include('shared._permissions', ['closed' => 'true', 'model' => $user ])
@endif--}}
