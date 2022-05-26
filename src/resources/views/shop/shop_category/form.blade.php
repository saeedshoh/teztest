<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Название' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($shopCategory->name) ? $shopCategory->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('tax') ? 'has-error' : ''}}">
    <label for="tax" class="control-label ">{{ 'Комиссия' }}</label>
    <input type="number" name="tax" class="form-control" id="tax"  value="{{ isset($shopCategory->tax) ? $shopCategory->tax : ''}}">
    {!! $errors->first('tax', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>
