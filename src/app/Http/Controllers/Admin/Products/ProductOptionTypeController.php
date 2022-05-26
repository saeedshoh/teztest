<?php namespace App\Http\Controllers\Admin\Products;


use App\Http\Controllers\Controller;
use App\Modules\Products\Models\ProductCategory;
use App\Modules\Products\Models\ProductOptionType;
use Illuminate\Http\Request;

class ProductOptionTypeController extends Controller
{

    public function index()
    {
        $productOptionTypes = ProductOptionType::with(['productCategory'])->paginate(15)->withQueryString();

        return view('product.option.type.index', ['productOptionTypes' => $productOptionTypes]);
    }

    public function create()
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->with('subCategory')
            ->orderby('name', 'asc')
            ->get()->toArray();

        return view('product.option.type.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_option_types',
            'name_ru' => 'required',
            'product_category_id' => 'required|exists:product_categories,id'
        ]);

        ProductOptionType::create($request->all());

        flash()->success('Тип для опции продукта успешно создан');

        return redirect()->route('option_types.index');
    }

    public function edit(int $id)
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->with('subCategory')
            ->orderby('name', 'asc')
            ->get()->toArray();
        $productOptionType = ProductOptionType::findOrFail($id);
        return view('product.option.type.edit', ['productOptionType' => $productOptionType, 'categories' => $categories]);
    }

    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_option_types',
            'name_ru' => 'required',
            'product_category_id' => 'required|exists:product_categories,id'
        ]);

        $productOptionType = ProductOptionType::findOrFail($id);

        $productOptionType->update($request->all());

        flash()->success('Тип для опции продукта успешно обновлен');

        return redirect()->route('option_types.index');
    }

    public function destroy(int $id)
    {
        ProductOptionType::destroy($id);

        flash()->success('Тип для опции продукта успешно удален');

        return redirect()->route('option_types.index');
    }

}
