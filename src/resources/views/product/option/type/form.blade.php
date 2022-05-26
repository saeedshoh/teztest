<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Название' }}</label>
    {{Form::input('text', 'name', old('name', $productOptionType->name ?? null), ['class' => "form-control"])}}
    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name_ru') ? 'has-error' : ''}}">
    <label for="name_ru" class="control-label">{{ 'Название на русском' }}</label>
    {{Form::input('text', 'name_ru', old('name_ru', $productOptionType->name_ru ?? null), ['class' => "form-control"])}}
    {!! $errors->first('name_ru', '<p class="help-block text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name_ru') ? 'has-error' : ''}}">
    {!! Form::label('product_category_id', 'Категории', ['class' => "col-md-2 col-form-label"]); !!}
    <select class="form-control select2" name="product_category_id">
        <option selected disabled>Выбрать ...</option>
        @foreach($categories as $category)
            <option
                value="{{$category['id']}}" {{$formMode === 'edit' && $category['id'] == $product->product_category_id ? 'selected' : '' }}>{{$category['name']}}</option>
            @foreach($category['sub_category'] as $sub)
                <option
                    value="{{$sub['id']}}" {{$formMode === 'edit' && $sub['id'] == $product->product_category_id ? 'selected' : '' }}>
                    -{{$sub['name']}}</option>
                @foreach($category['sub_category'] as $subsub)
                    <option
                        value="{{$subsub['id']}}" {{$formMode === 'edit' && $subsub['id'] == $product->product_category_id ? 'selected' : '' }}>
                        --{{$subsub['name']}}</option>
                @endforeach
            @endforeach
        @endforeach
    </select>
    {!! $errors->first('product_category_id', '<p class="help-block text-danger">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>
