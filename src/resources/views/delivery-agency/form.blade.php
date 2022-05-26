<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Название', ['class' => "control-label"]); !!}
    {!! Form::text('name', old('delivery_price', $deliveryAgency->name ?? null), ['class' => 'form-control'  ]) !!}
    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Описание' }}</label>
    <textarea class="form-control" name="description"
              id="description">{{old('description', $deliveryAgency->description ?? null)}}</textarea>
    {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
    {!! Form::label('phone_number', 'Номер телефона', ['class' => "control-label"]); !!}
    {!! Form::text('phone_number',  old('phone_number', $deliveryAgency->phone_number ?? 992), [
     'class' => 'form-control input-mask',
     'data-inputmask' => "'mask': '(999)-99-999-99-99', 'removeMaskOnSubmit': 'true'"
     ]) !!}
    {!! $errors->first('phone_number', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('delivery_price') ? 'has-error' : ''}}">
    {!! Form::label('delivery_price', 'Цена доставки', ['class' => "control-label"]); !!}
    {{Form::input('text', 'delivery_price', old('delivery_price', $deliveryAgency->delivery_price ?? null),[
        'class' => "form-control input-mask text-left",
        'data-inputmask' => "'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
    ])}}
    {!! $errors->first('delivery_price', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
    <label for="city_id">Выбрать город</label>
    <select class="form-control select2" name="city_id">
        <option selected disabled>Выбрать ...</option>
        @foreach($cities as $key => $value)
            <option value="{{$key}}" {{$formMode === 'edit' && $deliveryAgency->city_id == $key ? 'selected' : '' }}>
                {{$value}}
            </option>
        @endforeach
    </select>
    {!! $errors->first('city_id', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">Статус</label>
    <select class="form-control" name="status">
        <option value="ACTIVE" {{$formMode === 'edit' && $deliveryAgency->status == 'ACTIVE' ? 'selected' : '' }}>
            Активный
        </option>
        <option value="INACTIVE" {{$formMode === 'edit' && $deliveryAgency->status == 'INACTIVE' ? 'selected' : '' }}>
            Заблокировать
        </option>
    </select>
    {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}
</div>
@if($formMode !== 'edit' )
    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
        {!! Form::label('email', 'Почта (Логин)'); !!}
        {!! Form::text('email', old('email', $deliveryAgency->email ?? null),
            ['class' => 'form-control input-mask', 'data-inputmask' => "'alias': 'email'"])
        !!}
        {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
    </div>

    <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
        <label for="password" class="control-label">{{ 'Пароль' }}</label>
        <input class="form-control" name="password" type="password" id="password">
        {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
    </div>
@else
    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
        <label for="email" class="control-label">{{ 'Логин' }}</label>
        <div>{{$deliveryAgency->user->email}}</div>
    </div>
@endif
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>
