@extends('layouts.master')

@section('title') Все категории @endsection

@section('content')
    <script type="text/javascript">
        function FindNext () {
            var str = document.getElementById ("findInput").value;
            if (str == "") {
                alert ("Please enter some text to search!");
                return;
            }

            if (window.find) {        // Firefox, Google Chrome, Safari
                var found = window.find (str);
                if (!found) {
                    alert ("The following text was not found:\n" + str);
                }
            }
            else {
                alert ("Your browser does not support this example!");
            }
        }
        function selectSubmitForm(e){
            if(e.keyCode === 13){
                FindNext();
            }
        }
    </script>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <input class="form-control" type="text" id="findInput"  size="20" onkeypress="selectSubmitForm(event);" placeholder="Поиск..." />
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">Все категории</h4>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-primary waves-effect waves-light float-right"
                               href="{{route('categories.create')}}">Создать</a>
                        </div>
                    </div>
                    <ul style="list-style-type: none;">
                        @if(count($categories) > 0)
                            @foreach ($categories as $category)
                                <li>
                                    @if($category->icon)<img src="{{$category->IconUri}}" width="20"  alt=""/>@endif
                                    <b>{{ $category->name }} <span class="text-danger">({{$category->products_count}})</span></b>
                                    <a href="{{route('categories.create', ['id' => $category->id, 'name' => $category->name])}}">
                                        <i class="mdi mdi-folder-plus font-size-18"></i>
                                    </a>
                                    <a href="{{ route('categories.audit', $category->id) }}">
                                        <i class="mdi mdi-history font-size-18"></i>
                                    </a>
                                    <a href="{{route('categories.create', ['id' => $category->id, 'name' => $category->name])}}">
                                        <i class="mdi mdi-folder-plus font-size-18"></i>
                                    </a>
                                    {!! Form::open(['method' => 'delete', 'url' => route('categories.destroy', ['category' => $category->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to delete it?")']) !!}
                                        <button type="submit"
                                                class="text-danger"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                style="border: none; background: transparent; padding: 0;"
                                                data-original-title="Delete">
                                            <i class="mdi mdi-close font-size-18"></i>
                                        </button>
                                    {!! Form::close() !!}
                                </li>
                                <ul style="list-style-type: none;">
                                    @if(count($category->subCategoryAdmin))
                                        @foreach ($category->subCategoryAdmin as $subCategories)
                                            @include('product.categories.sub_categories', ['sub_categories' => $subCategories])
                                        @endforeach
                                    @endif
                                </ul>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection


