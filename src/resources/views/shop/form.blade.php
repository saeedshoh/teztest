<div class="card">
    <div class="card-body">
        <h4 class="card-title">{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }} магазин</h4>
        <p class="card-title-desc">Заполните все поля</p>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Название</label>
                    {!! Form::input('text', 'name', old('name', $shop->name ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    <label for="shop_category_id">Выбрать категорию</label>
                    <select class="form-control" name="shop_category_id">
                        <option selected disabled>Выбрать ...</option>
                        @foreach($shopCategories as $key => $value)
                            <option value="{{$key}}" {{$formMode === 'edit' && $key == $shop->shop_category_id ? 'selected' : '' }}>{{$value}}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('shop_category_id', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="city_id">Выбрать город</label>
                    <select class="form-control" name="city_id">
                        <option selected disabled>Выбрать ...</option>
                        @foreach($cities as $key => $value)
                            <option value="{{$key}}" {{$formMode === 'edit' && $key == $shop->city_id ? 'selected' : '' }}>{{$value}}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('city_id', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('address', 'Адрес'); !!}
                    {!! Form::input('text', 'address', old('address', $shop->address ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('address', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="col-sm-6">
                <?php $disablePhoneNumber = $formMode === 'edit' ? ['disabled' => true]: []; ?>
                <div class="form-group">
                    {!! Form::label('phone_number', 'Номер телефона'); !!}
                    {!! Form::text('phone_number',  old('phone_number', $shop->phone_number ?? 992), [
                     'class' => 'form-control input-mask',
                     'data-inputmask' => "'mask': '(999)-99-999-99-99', 'removeMaskOnSubmit': 'true'"
                     ] + $disablePhoneNumber)  !!}
                    {!! $errors->first('phone_number', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('logo', 'Логотип'); !!}
                    {!! Form::file('logo', ['class' => 'form-control']); !!}
                    {!! $errors->first('logo', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="description">Описание</label>
                    {!! Form::label('description', 'Описание'); !!}
                    {!! Form::textarea('description', old('description', $shop->description ?? null), ['class' => 'form-control', 'rows' => 5]); !!}
                    {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('company_name', 'Название компании'); !!}
                    {!! Form::text('company_name', old('description', $shop->company_name ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('company_name', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('company_type', 'Тип компании'); !!}
                    <select class="form-control" name="company_type">
                        <option value="entrepreneur" {{$formMode === 'edit' && 'entrepreneur' == $shop->company_type ? 'selected' : '' }}>ЧП</option>
                        <option value="legal_entity" {{$formMode === 'edit' && 'legal_entity' == $shop->company_type ? 'selected' : '' }}>Юр. лицо</option>
                    </select>
                    {!! $errors->first('company_type', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('company_account_number', 'Сч №'); !!}
                    {!! Form::text('company_account_number', old('company_account_number', $shop->company_account_number ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('company_account_number', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('bank_name', 'Название Банка'); !!}
                    {!! Form::text('bank_name', old('bank_name', $shop->bank_name ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('bank_name', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('delivery_price', 'Цена доставки'); !!}
                    {!! Form::text('delivery_price', old('delivery_price', $shop->delivery_price ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('delivery_price', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('tin', 'ИНН'); !!}
                    {!! Form::text('tin', old('tin', $shop->tin ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('tin', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('sin', 'SIN'); !!}
                    {!! Form::text('sin', old('sin', $shop->sin ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('sin', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('bik', 'БИК'); !!}
                    {!! Form::text('bik', old('bik', $shop->bik ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('bik', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('bank_account_number', 'Банк счет'); !!}
                    {!! Form::text('bank_account_number', old('bank_account_number', $shop->bank_account_number ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('bank_account_number', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('estimated_delivery_time', 'Срок доставки'); !!}
                    {!! Form::text('estimated_delivery_time', old('estimated_delivery_time', $shop->estimated_delivery_time ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('estimated_delivery_time', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('full_name', 'ФИО'); !!}
                    {!! Form::text('full_name', old('full_name', $shop->user->name ?? null), ['class' => 'form-control']) !!}
                    {!! $errors->first('full_name', '<p class="help-block text-danger">:message</p>') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Пароль'); !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                    {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('email', 'Почта (Логин)'); !!}
                    {!! Form::text('email', old('email', $shop->user->email ?? null), ['class' => 'form-control input-mask', 'data-inputmask' => "'alias': 'email'"]) !!}
                    {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
        </div>
        {!! Form::submit($formMode === 'edit' ? 'Обновить' : 'Создать', ['class' => 'btn btn-primary mr-1 waves-effect waves-light float-right']) !!}
    </div>
</div>
