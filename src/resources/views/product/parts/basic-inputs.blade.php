<div>
    <h4 class="card-title">Основная информация</h4>
    <p class="card-title-desc">Заполните всю информацию ниже </p>
    <div class="form-group row mb-4">
        {!! Form::label('title', 'Название', ['class' => "col-md-2 col-form-label"]); !!}
        <div class="col-md-10">
            {!! Form::input('text', 'title',  old('title', $product->title ?? null), ['class' => 'form-control']) !!}
            {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="form-group row mb-4">
        {!! Form::label('price', 'Цена', ['class' => "col-md-2 col-form-label"]); !!}
        <div class="col-md-10">
            {{Form::input('text', 'price', old('price', $product->price ?? null), [
                'class' => "form-control input-mask text-left",
                'data-inputmask' => "'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false"
            ])}}
            {!! $errors->first('price', '<p class="help-block text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="form-group row mb-4">
        {!! Form::label('sale', 'Скидка в процентах', ['class' => "col-md-2 col-form-label"]); !!}
        <div class="col-md-10">
            {{Form::input('number', 'sale', old('sale', $product->sale ?? 0), ['class' => "form-control input-mask text-left"])}}
            {!! $errors->first('sale', '<p class="help-block text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="form-group row mb-4">
        {!! Form::label('quantity', 'Количество', ['class' => "col-md-2 col-form-label"]); !!}
        <div class="col-md-10">
            {{Form::input('number', 'quantity', old('quantity', $product->quantity ?? null), ['class' => "form-control input-mask text-left"])}}
            {!! $errors->first('quantity', '<p class="help-block text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="form-group row mb-4">
        {!! Form::label('product_category_id', 'Категории', ['class' => "col-md-2 col-form-label"]); !!}
        <div class="col-md-10">
            <select class="form-control select2" name="product_category_id">
                <option selected disabled>Выбрать ...</option>
                @foreach($categories as $category)
                    <option
                        value="{{$category['id']}}" {{$formMode === 'edit' && $category['id'] == $product->product_category_id ? 'selected' : '' }}>{{$category['name']}}</option>
                    @foreach($category['sub_category'] as $sub)
                        <option
                            value="{{$sub['id']}}" {{$formMode === 'edit' && $sub['id'] == $product->product_category_id ? 'selected' : '' }}>
                            -{{$sub['name']}}</option>
                        @foreach($sub['sub_category'] as $subsub)
                            <option
                                value="{{$subsub['id']}}" {{$formMode === 'edit' && $subsub['id'] == $product->product_category_id ? 'selected' : '' }}>
                                --{{$subsub['name']}}</option>
                        @endforeach
                    @endforeach
                @endforeach
            </select>
            {!! $errors->first('product_category_id', '<p class="help-block text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="form-group row mb-4">
        {!! Form::label('brand_id', 'Бренд', ['class' => "col-md-2 col-form-label"]); !!}
        <div class="col-md-10">
            <select class="form-control select2" name="brand_id">
                <option selected disabled>Выбрать ...</option>
                @foreach($brands as $brand)
                    <option
                        value="{{$brand->id}}" {{$formMode === 'edit' && $brand->id == $product->brand_id ? 'selected' : '' }}>{{$brand->name}}</option>
                @endforeach
            </select>
            {!! $errors->first('brand_id', '<p class="help-block text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="form-group row mb-4">
        {!! Form::label('description', 'Описание', ['class' => "col-md-2 col-form-label"]); !!}
        <div class="col-md-10">
            {!! Form::textarea('description', old('description', $product->description ?? null), ['rows' => 3, 'class' => 'form-control']) !!}
        </div>
        {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
    </div>
    @role('admin')
        <div class="form-group row mb-4">
            {!! Form::label('rank', 'Ранг', ['class' => "col-md-2 col-form-label"]); !!}
            <div class="col-md-10">
                {{Form::input('number', 'rank', old('rank', $product->rank ?? null), ['class' => "form-control input-mask text-left"])}}
                {!! $errors->first('rank', '<p class="help-block text-danger">:message</p>') !!}
            </div>
            {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
        </div>
        <div class="form-group row mb-4">
            {!! Form::label('shop_id', 'Магазин', ['class' => "col-md-2 col-form-label"]); !!}
            <div class="col-md-10">
                <select class="form-control select2" name="shop_id">
                    <option selected disabled>Выбрать ...</option>
                    @foreach($shops as $shop)
                        <option
                            value="{{$shop->id}}" {{$formMode === 'edit' && $shop->id == $product->shop_id ? 'selected' : '' }}>{{$shop->name}}</option>
                    @endforeach
                </select>
                {!! $errors->first('shop_id', '<p class="help-block text-danger">:message</p>') !!}
            </div>
        </div>
    @endrole
    {!! Form::submit($formMode === 'edit' ? 'Изменить' : 'Создать и перейти на след. шаг', ['class' => 'btn btn-primary mr-1 waves-effect waves-light float-right']) !!}

</div>
