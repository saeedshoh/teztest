<?php namespace App\Http\Controllers\Admin\Products;


use App\Http\Controllers\Controller;
use App\Modules\Products\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ProductOptionController extends Controller
{
    public function store(Request $request)
    {
        $optionValueType = $request->product_option_type_id;
        $this->validate($request, [
            'product_option_type_id' => 'required',
            'product_id' => 'required|exists:products,id',
            'product_option_value_id' => [
                'required',
                Rule::exists('product_option_values', 'id')->where(function ($query) use ($optionValueType) {
                    $query->where('product_option_type_id', $optionValueType);
                }),
            ],
            'option_price' => 'required',
        ]);

        ProductOption::create($request->all());

        flash()->success("Новая опция создана успешно!");

        Session::flash('tabPos', 3);

        return redirect("/products/{$request->product_id}/edit");
    }

    public function destroy(int $id)
    {
        $productOption = ProductOption::findOrFail($id);
        $productOption->delete();

        flash()->success('Атрибут успешно удален');

        Session::flash('tabPos', 3);

        return redirect("/products/{$productOption->product_id}/edit");
    }

}
