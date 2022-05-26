<?php namespace App\Http\Controllers\Admin\Products;


use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;


class ProductStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['perm:status_pending_products'])->only(['changeToPending']);
        $this->middleware(['perm:status_active_products'])->only(['changeToActive']);
        $this->middleware(['perm:status_denied_products'])->only(['changeToDenied']);
    }

    public function changeToPending(Product $product)
    {
        if(auth()->user()->hasRole('merchant') && auth()->user()->shop_id != $product->shop_id) {
            redirect('/');
        }

        $product->update(['status' => Product::STATUS_PENDING]);
        flash()->success('Статус продукта изменен на Модерацию');

        if (auth()->user()->hasRole('merchant')){
            return redirect('/products/shop');
        }
        return redirect('/products/');
    }

    public function changeToActive(Product $product)
    {
        $product->update(['status' => Product::STATUS_ACTIVE]);
        flash()->success('Статус продукта изменен на Активный');
        return redirect("/products/$product->id/edit");
    }

    public function changeToDenied(Product $product)
    {
        $product->update(['status' => Product::STATUS_DENIED]);
        flash()->success('Статус продукта изменен на Отказано');
        return redirect("/products/$product->id/edit");
    }
}
