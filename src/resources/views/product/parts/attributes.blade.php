<div>
    <h4 class="card-title mb-4">Атрибуты товара</h4>

    <div class="table-responsive">
        <table class="table table-centered table-nowrap">
            <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Тип значении</th>
                <th>Значение</th>
                <th>Цена</th>
                <th>Дата добавления</th>
                @can('edit_users', 'delete_users')
                    <th>Действии</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($productOptions as $item)
                <tr>
                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ $item->id }}</a></td>
                    <td>{{ $item->productOptionType->name_ru }}</td>
                    <td>{{ $item->productOptionValue->name_ru }}</td>
                    <td>{{ $item->option_price }}</td>
                    <td>{{ $item->created_at->toFormattedDateString() }}</td>
                    @can('edit_users')
                        <td>
                            @include('shared._actions', [
                                 'entity' => 'options',
                                 'id' => $item->id,
                                 'actions' => ['delete']
                             ])
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <hr>
    {!! Form::open(['url' => ['/products/options']]) !!}
    <input type="hidden" name="product_id" value="{{$product->id}}">
    <div class="row">
        <div class="form-group col-lg-3">
            <label for="product_option_type_id">Тип атрибута</label>
            <select class="form-control select2" name="product_option_type_id" id="product_option_type_id">
                <option value="">Выбрать...</option>
                @foreach($productOptionTypes as $optionTypeKey => $optionTypeValue)
                    <option value="{{$optionTypeKey}}">
                        {{$optionTypeValue}}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('product_option_type_id', '<p class="help-block text-danger">:message</p>') !!}
        </div>

        <div class="form-group col-lg-3">
            <label for="product_option_type_id">Значения атрибута</label>
            <select class="form-control" name="product_option_value_id" id="product_option_value_id">
            </select>
            {!! $errors->first('product_option_value_id', '<p class="help-block text-danger">:message</p>') !!}
        </div>

        <div class="form-group col-lg-3">
            <label for="option_price">Цена</label>
            <input step=".01" type="number" id="option_price" class="form-control" name="option_price"/>
            {!! $errors->first('option_price', '<p class="help-block text-danger">:message</p>') !!}
        </div>

        <div class="col-lg-3 align-self-center">
            <input type="submit" class="btn btn-primary btn-block" value="Добавить"/>
        </div>

    </div>
    <hr>
    {!! Form::close() !!}
    @if($product->status == 'DRAFT')
        <form method="POST" action="{{ url('/products/statuses/pending/' . $product->id) }}" class="form-horizontal">
            @method('PUT')
            @csrf
            <input type="submit" class="btn btn-primary btn-block float-right" value="Закончить и отправить на модерацию"/>
        </form>
    @else
        <a class="btn btn-primary mr-1 waves-effect waves-light float-right" data-toggle="pill" href="/products/shop" >
            Закрыть
        </a>
    @endif


</div>

@push('scripts')
    <script type="text/javascript">
        $('#product_option_type_id').change(function () {
            let optionTypeID = $(this).val();
            $("#product_option_value_id").empty();
            if (optionTypeID) {
                console.log(optionTypeID);
                $.ajax({
                    type: "GET",
                    url: "/products/option_values/" + optionTypeID + "/by_option_type",
                    success: function (res) {
                        $("#product_option_value_id").empty();
                        if (res) {
                            $("#product_option_value_id").empty();
                            $.each(res, function (key, value) {
                                $("#product_option_value_id").append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    }
                });
            }
        });
    </script>
@endpush
