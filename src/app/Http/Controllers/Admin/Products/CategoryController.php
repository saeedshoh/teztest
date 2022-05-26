<?php namespace App\Http\Controllers\Admin\Products;


use App\Modules\Products\Models\Product;
use Illuminate\Support\Facades\Cache;
use Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Modules\Common\Traits\UploadTrait;
use App\Modules\Products\Models\ProductCategory;

class CategoryController extends Controller
{
    use UploadTrait;
    public function __construct()
    {
        //$this->middleware(['perm:example'])->only(['index']);
    }
    public function index()
    {
        $categories = ProductCategory::withCount('products')->whereNull('parent_id')
            ->with('subCategoryAdmin')
            ->orderby('name')
            ->get();

        return view('product.categories.index', ['categories' =>  $categories]);
    }

    public function create()
    {
        return view('product.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => [
                'required',
                'image',
                'mimes:png',
                'dimensions:min_width=50min_height=50,max_width=300,max_height=300',
            ],
        ]);

        $getData = $this->uploadIcon($request);
        ProductCategory::create($getData);
        Cache::forget('app.modules.products.repositories.categoryrepository::getallcategories');
        flash()->success("Категория создана.");
        return redirect()->route('categories.index');
    }

    public function edit(ProductCategory $category)
    {
        return view('product.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, ProductCategory $category)
    {
        $request->validate([
            'name' => 'required',
            'logo' => [
                'image',
                'mimes:png',
                'dimensions:min_width=50min_height=50,max_width=300,max_height=300',
            ],
        ]);

        $getData = $this->uploadIcon($request);
        $category->update($getData);
        Cache::forget('app.modules.products.repositories.categoryrepository::getallcategories');
        flash()->success("Категория обновлена.");
        return redirect()->route('categories.index');
    }

    public function destroy(ProductCategory $category)
    {
        $generalCatId = (int) config("product.general_category");
        if ($generalCatId === $category->id){
            flash()->error("Общую категорию нельзя удалять");
            return redirect()->route('categories.index');
        }
        $updateProduct = Product::where('product_category_id', $category->id)->update([
           'product_category_id' => $generalCatId
        ]);

        if ($updateProduct){
            flash()->error("что-то пошло не так(");
            return redirect()->route('categories.index');
        }

        $category->delete();
        flash()->success("Категория удалена");
        return redirect()->route('categories.index');
    }

    private function uploadIcon(Request $request)
    {
        $iconName = null;

        if ($request->icon) {
            $folder = '/media/products/categories';
            $name = Str::slug($request->icon->getClientOriginalName()) . time();
            $this->uploadOne($request->icon, $folder, 'public', $name);
            $iconName = $name . '.' . $request->icon->getClientOriginalExtension();
        }

        return ['name' => $request->name, 'parent_id' => $request->parent_id, 'icon' => $iconName];
    }

    public function audit(ProductCategory $category)
    {
        $audits = $category->audits()->with(['user'])->paginate();
        //dd($audits);
        return view('product.categories.audit', ['audits' => $audits]);
    }
}
