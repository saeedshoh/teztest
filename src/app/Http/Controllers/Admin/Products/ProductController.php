<?php namespace App\Http\Controllers\Admin\Products;


use App\Http\Controllers\Controller;
use App\Modules\Common\Traits\UploadTrait;
use App\Modules\Products\Models\Brand;
use App\Modules\Products\Models\ProductCategory;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductMedia;
use App\Modules\Products\Models\ProductOption;
use App\Modules\Products\Models\ProductOptionType;
use App\Modules\Products\Repositories\ProductRepository;
use App\Modules\Shops\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    use UploadTrait;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware(['perm:view_products'])->only(['index']);
        $this->middleware(['perm:add_products'])->only(['store', 'create']);
        $this->middleware(['perm:edit_products'])->only(['update', 'edit']);
        $this->middleware(['perm:view_shop_products'])->only(['getByShopId']);
        $this->middleware(['perm:delete_products'])->only(['destroy']);
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $productCategoryId = $request->input('product_category_id');
        $productStatus = $request->input('product_status');
        $searchText = $request->input('search_text');
        $price = $request->input('price');
        $shopId = $request->input('shop_id');

        $query = Product::with(['productCategory', 'productMedia', 'shop'])->withCount(['orderProducts']);

        if ($searchText) {
            $query->where('title', 'like', "%$searchText%");
        }

        if ($productCategoryId) {
            $query->where('product_category_id', $productCategoryId);
        }

        if ($productStatus){
            $query->where('status', $productStatus);
        }

        if ($price){
            $query->where('price', $price);
        }

        if ($shopId){
            $query->where('shop_id', $shopId);
        }

        $shops = Shop::where('status', Shop::STATUS_ACTIVE)->get();
        $query->orderBy('id', 'DESC');

        $getFilters['productStatuses'] = Product::STATUSES_ARRAY;

        $categories = ProductCategory::withCount('products')->whereNull('parent_id')
            ->with('subCategory')
            ->orderby('name')
            ->get()->toArray();

        return view('product.index', [
            'products' => $query->paginate(12)->withQueryString(),
            'filters' => $getFilters,
            'categories' => $categories,
            'shops' => $shops
        ]);
    }

    public function getProductsTable(Request $request)
    {
        $product_category_id = $request->input('product_category_id');
        $title = $request->input('title');
        $price = $request->input('price');
        $id = $request->input('id');
        $status = $request->input('status');

        if ($title) {
            $query = Product::search($title)->with(['productCategory', 'shop']);
        } else {
            $query = Product::with(['productCategory', 'shop']);
        }

        if ($product_category_id) {
            $query->where('product_category_id', $product_category_id);
        }

        if ($id) {
            $query->where('id', $id);
        }

        if ($price) {
            $query->where('price', $price);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $query->orderBy('id', 'DESC');

        $filters['productCategories'] = ProductCategory::whereNull('parent_id')
            ->with('subCategory')
            ->orderby('name')
            ->get()->toArray();

        $filters['productStatuses'] = Product::STATUSES_ARRAY;

        return view('product.on-table', ['products' => $query->paginate(12)->withQueryString(), 'filters' => $filters]);
    }

    public function show(int $id)
    {
        $product = Product::with(['productCategory', 'productMedia'])->find($id);
        return view('product.show', ['product' => $product]);
    }

    public function create()
    {
        if (!isset(auth()->user()->shop_id) && !auth()->user()->hasRole('admin')) {
            flash()->error("Вы не сможете создать продукт, так как у вас нет магазина");
            return redirect('/products/shop');
        }
        $categories = ProductCategory::whereNull('parent_id')
            ->with('subCategory')
            ->orderby('name', 'asc')
            ->get()->toArray();
        $brands = Brand::all();
        $shops = Shop::where('status', Shop::STATUS_ACTIVE)->get();

        return view('product.create', [
            'categories' => $categories,
            'brands' => $brands,
            'shops' => $shops
        ]);
    }

    public function store(Request $request)
    {
        $isAdmin = auth()->user()->hasRole('admin');
        if (! isset(auth()->user()->shop_id) && ! $isAdmin) {
            flash()->error("Вы не сможете создать продукт, так как у вас нет магазина");
            return redirect('/products/shop');
        }

        $adminValidation = [];
        if ($isAdmin){
            $adminValidation['shop_id'] = [
                'required',
                'exists:shops,id'
            ];
        }

        $request->validate([
            'title' => 'required',
            'price' => 'required|between:1,99999.99',
            'quantity' => 'required|min:1',
            'product_category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'description' => 'string|nullable',
            'status' => 'string',
            'sale' => 'required|integer|between:0,100',
        ] + $adminValidation);

        $fields = $request->all();
        $fields['shop_id'] = $isAdmin ? $request->shop_id : auth()->user()->shop_id;
        $fields['user_id'] = auth()->user()->getAuthIdentifier();
        $fields['is_sale'] = $fields['sale'] > 0;

        $product = Product::create($fields);

        flash()->success("Продукт успешно добавлен");

        Session::flash('tabPos', 2);

        return redirect()->route('products.edit', ['product' => $product->id]);
    }

    public function update(Request $request, Product $product)
    {
        $isAdmin = auth()->user()->hasRole('admin');
        if (! isset(auth()->user()->shop_id) && ! $isAdmin) {
            flash()->error("Вы не сможете создать продукт, так как у вас нет магазина");
            return redirect('/products/shop');
        }

        $adminValidation = [];
        if ($isAdmin){
            $adminValidation['shop_id'] = [
                'required',
                'exists:shops,id'
            ];
        }

        $request->validate([
            'title' => 'required',
            'price' => 'required|between:1,99999.99',
            'quantity' => 'required|min:1',
            'product_category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'description' => 'string|nullable',
            'status' => 'string',
            'sale' => 'required|integer|between:0,100',
            'rank' => 'integer|nullable'
        ] + $adminValidation);

        $fields = $request->all();
        $fields['shop_id'] = $isAdmin ? $request->shop_id : auth()->user()->shop_id;
        $fields['user_id'] = auth()->user()->getAuthIdentifier();

        $product->update($fields);

        flash()->success("Продукт успешно изменен");

        Session::flash('tabPos', 2);

        return redirect("/products/{$product->id}/edit");
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();
        $productOptionTypes = ProductOptionType::where('product_category_id', $product->product_category_id)->get()->pluck('name_ru', 'id')->toArray();
        $productOptions = ProductOption::with(['productOptionType', 'productOptionValue'])->where('product_id', $product->id)->paginate(100);
        $categories = ProductCategory::whereNull('parent_id')
            ->with('subCategory')
            ->orderby('name', 'asc')
            ->get()
            ->toArray();

        Session::has('tabPos') ?
            Session::flash('tabPos', Session::get('tabPos')) :
            Session::flash('tabPos', 1);

        $shops = Shop::where('status', Shop::STATUS_ACTIVE)->get();

        return view('product.edit', [
            'statuses' => Product::STATUSES_ARRAY,
            'categories' => $categories,
            'brands' => $brands,
            'product' => $product,
            'shops' => $shops,
            'productOptions' => $productOptions,
            'productOptionTypes' => $productOptionTypes
        ]);
    }

    public function uploadProductMedia(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_media.*' => 'required|mimes:png|max:10000'
        ]);

        foreach ($request->product_media as $file) {
            $fileName = $this->uploadProductImage($file);

            ProductMedia::create([
                'product_id' => $request->product_id,
                'file_name' => $fileName
            ]);
        }

        flash()->success("Новые файлы были добавлены успешно!");

        Session::flash('tabPos', 2);

        return redirect("/products/{$request->product_id}/edit");
    }

    public function deleteProductMedia(ProductMedia $productMedia)
    {
        $productMedia->delete();
        $folder = '/media/products/images';

        File::delete($folder . "/small/{$productMedia->file_name}");
        File::delete($folder . "/original/{$productMedia->file_name}");
        Session::flash('tabPos', 2);
        flash()->success("Фотография успешно удалена.");


        return redirect("/products/{$productMedia->product_id}/edit");
    }

    public function isDefaultProductMedia(ProductMedia $productMedia)
    {
        ProductMedia::where('product_id', $productMedia->product_id)->update(['is_default' => 0]);
        $productMedia->update(['is_default' => 1]);
        flash()->success("Главная фотография изменена");
        Session::flash('tabPos', 2);

        return redirect("/products/{$productMedia->product_id}/edit");
    }

    public function getByShopId(Request $request)
    {
        $searchText = $request->input('search_text');
        $product_category_id = $request->input('product_category_id');

        if ($searchText) {
            $productsId = Product::search($searchText)->keys();
            $query = Product::with(['productCategory', 'productMedia'])->whereIn('id', $productsId);
        } else {
            $query = Product::with(['productCategory', 'productMedia']);
        }

        if ($product_category_id) {
            $query->where('product_category_id', $product_category_id);
        }
        $query->where('shop_id', auth()->user()->shop_id)->orderBy('id', 'DESC');

        $categories = ProductCategory::whereNull('parent_id')
            ->with('subCategory')
            ->orderby('name', 'asc')
            ->get()->toArray();

        return view('product.shop', ['products' => $query->paginate(12)->withQueryString(), 'categories' => $categories]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        flash()->success("Продукт успешно удален.");
        return redirect($this->redirectRole());
    }

    private function redirectRole(): string
    {
        switch (\Auth::user()->roles->pluck('name')->first()){
            case 'admin' :
                $link = '/products';
                break;
            case 'moderator' :
                $link = '/products/table';
                break;
            case 'merchant' :
                $link = '/products/shop';
                break;
            default :
                $link = '/products';
        }
        return  $link;
    }
}
