<?php namespace App\Http\Controllers\Admin\Shops;


use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Shops\Models\ShopCategory;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ShopCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('name');
        $tax = $request->get('tax');
        $createdAt = $request->get('created_at');

        $shopCategories = ShopCategory::query();

        if ($id) {
            $shopCategories->where('name', $id);
        }

        if ($name) {
            $shopCategories->where('name', 'like', "%$name");
        }

        if ($tax) {
            $shopCategories->where('tax', $tax);
        }

        if ($createdAt) {
            $createdAt = Carbon::parse($createdAt);
            $shopCategories->whereDate('created_at', $createdAt);
        }

        return view('shop.shop_category.index', ['shopCategories' => $shopCategories->latest()->paginate(25)->withQueryString()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('shop.shop_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'tax' => 'required|integer|between:0,100',
        ]);

        $requestData = $request->all();

        ShopCategory::create($requestData);
        flash()->success('Категория магазинов успешно удален');
        return redirect('shops/shop_categories');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function show($id)
    {
        $shopCategory = ShopCategory::findOrFail($id);

        return view('shop.shop_category.show', ['shopCategory' => $shopCategory]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $shopCategory = ShopCategory::findOrFail($id);

        return view('shop.shop_category.edit', ['shopCategory' => $shopCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'tax' => 'required|integer|between:0,100',
        ]);

        $requestData = $request->all();

        $shop = ShopCategory::findOrFail($id);
        $shop->update($requestData);

        flash()->success('Категория магазинов успешно создан');

        return redirect('shops/shop_categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        ShopCategory::destroy($id);
        flash()->success('Категория магазинов успешно удален');
        return redirect('shops/shop_categories');
    }
}
