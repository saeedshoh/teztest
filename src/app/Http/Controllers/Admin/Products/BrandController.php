<?php namespace App\Http\Controllers\Admin\Products;


use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $query = Brand::withCount(['products']);

        $query->when(request('id', false), function ($q, $id){
            return $q->where('id', $id);
        });

        $query->when(request('name', false), function ($q, $searchText){
            return $q->where('name', 'like', "%$searchText%");
        });

        $query->when(request('description', false), function ($q, $description){
            return $q->where('description', 'like', "%$description%");
        });

        if ($createdAt = request('created_at', false)) {
            $createdAt = Carbon::parse($createdAt);
            $query->whereDate('created_at', $createdAt);
        }

        return view('product.brands.index', [
            'brands' =>  $query->orderBy('products_count', 'DESC')->paginate()->withQueryString()
        ]);
    }

    public function create()
    {
        return view('product.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Brand::create($request->all());

        return redirect()->route('brands.index')->with('success', 'Бренд созданно.');
    }

    public function edit(Brand $brand)
    {
        return view('product.brands.edit', ['brand' => $brand]);
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $brand->update($request->all());

        return redirect()->route('brands.index')->with('success', 'Бренд обновлен.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Бренд удален');
    }

}
