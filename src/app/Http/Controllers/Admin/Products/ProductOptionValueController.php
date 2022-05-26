<?php namespace App\Http\Controllers\Admin\Products;


use App\Http\Controllers\Controller;
use App\Modules\Products\Models\ProductOptionType;
use App\Modules\Products\Models\ProductOptionValue;
use Illuminate\Http\Request;

class ProductOptionValueController extends Controller
{
    public function index()
    {
        $productOptionValues = ProductOptionValue::paginate(15)->withQueryString();

        return view('product.option.value.index', ['productOptionValues' => $productOptionValues]);
    }

    public function create()
    {
        $productOptionTypes = ProductOptionType::get()->pluck('name', 'id')->toArray();

        return view('product.option.value.create', ['productOptionTypes' => $productOptionTypes]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_option_values',
            'name_ru' => 'required',
            'product_option_type_id' => 'required|exists:product_option_types,id'
        ]);

        ProductOptionValue::create($request->all());

        flash()->success('Значение для опции продукта успешно создан');

        return redirect()->route('option_values.index');
    }

    public function edit(int $id)
    {
        $productOptionType = ProductOptionType::findOrFail($id);
        return view('product.option.type.edit', ['productOptionType' => $productOptionType]);
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_option_values',
            'name_ru' => 'required',
            'product_option_type_id' => 'required|exists:product_option_types,id'
        ]);

        $productOptionType = ProductOptionType::findOrFail($id);

        $productOptionType->update($request->all());

        flash()->success('Тип для опции продукта успешно обновлен');

        return redirect()->route('option_types.index');
    }

    public function destroy(int $id)
    {
        ProductOptionValue::destroy($id);

        flash()->success('Значение для опции продукта успешно удален');

        return redirect()->route('option_values.index');
    }

    public function optionValueByOptionType(int $optionTypeId)
    {
        $optionValues = ProductOptionValue::where('product_option_type_id', $optionTypeId)
            ->pluck("name_ru", "id");
        return response()->json($optionValues);
    }
}
