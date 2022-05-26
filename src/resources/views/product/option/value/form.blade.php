<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Название' }}</label>
    {{Form::input('text', 'name', old('name', $productOptionValue->name ?? null), ['class' => "form-control"])}}
    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name_ru') ? 'has-error' : ''}}">
    <label for="name_ru" class="control-label">{{ 'Название на русском' }}</label>
    {{Form::input('text', 'name_ru', old('name_ru', $productOptionValue->name_ru ?? null), ['class' => "form-control"])}}
    {!! $errors->first('name_ru', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name_ru') ? 'has-error' : ''}}">
    <label for="name_ru" class="control-label">{{ 'Тип' }}</label>
    <select class="form-control select2" name="product_option_type_id">
        <option selected disabled>Выбрать ...</option>
        @foreach($productOptionTypes as $optionTypeKey => $optionTypeValue)
            <option value="{{$optionTypeKey}}" {{$formMode === 'edit' && $optionTypeKey == $productOptionValue->product_option_type_id ? 'selected' : '' }}>
                {{$optionTypeValue}}
            </option>
        @endforeach
    </select>
    {!! $errors->first('product_option_type_id', '<p class="help-block text-danger">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>
