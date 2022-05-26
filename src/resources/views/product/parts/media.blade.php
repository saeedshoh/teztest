<div>
    <h4 class="card-title">Фотографии товара</h4>
    <p class="card-title-desc">Добавьте фотографии</p>
    <div class="row">
        <div class="col-12">
            <div class="popup-gallery">

                <div class="row">
                    @foreach($product->productMedia as $media)

                            <div class="col-sm-4">
                                <a class="float-left" href="{{$media->file_uri}}"
                                   title="{{$media->file_name}}">
                                    <div class="img-fluid">
                                        <img src="{{$media->file_uri}}" alt="" width="300">
                                    </div>
                                </a>
                                <div class="row">
                                    <div class="col-md-1">
                                        {!! Form::open(['method' => 'delete', 'url' => "/products/images/delete/{$media->id}", 'onSubmit' => 'return confirm("Вы дейтвительно хотите удалить?")']) !!}
                                        <button type="submit"
                                                class="text-danger"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                style="border: none; background: transparent; padding: 0;"
                                                data-original-title="Удалить">
                                            <i class="mdi mdi-close font-size-18"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                    @if($media->is_default == 0)
                                    <div class="col-md-1">
                                        <form method="POST" action="{{ url('/products/images/is_default/' . $media->id) }}" class="form-horizontal">
                                            @method('PUT')
                                            @csrf
                                        <button type="submit"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                style="border: none; background: transparent; padding: 0;"
                                                data-original-title="Сделать главной">
                                            <i class="mdi mdi-eye font-size-18"></i>
                                        </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <hr>
    {!! Form::open(['url' => ['/products/images/upload'], 'enctype'=>"multipart/form-data" ]) !!}
    <div class="row">
        <div class="col-12">
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile"
                       name="product_media[]" multiple onchange="form.submit(); this.disabled = true">
                <label class="custom-file-label" for="customFile">Выбрать файл</label>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <hr>
    <div class="row">
        <div class="col-12">
            <a class="btn btn-primary mr-1 waves-effect waves-light float-right" data-toggle="pill" href="#"
               onclick="activeAttributes()">
                Следующий шаг
            </a>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function activeAttributes() {
            $('[href="#v-pills-attributes"]').tab('show');
        };
    </script>
@endpush

