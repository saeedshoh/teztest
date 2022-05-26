<?php namespace App\Modules\Shops\Repositories;

use App\Http\Resources\ShopResource;
use App\Modules\Products\Models\Product;
use App\Modules\Shops\Models\Shop;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShopRepository
{
    public function getAll()
    {
        $query = Shop::query()->where('status', Shop::STATUS_ACTIVE);

        $limit = request('limit', 16);
        $orderBy = request('sorting_field', 'id');
        $direction = request('sorting_direction', 'desc');

        $query->when(request('search', false), function ($q, $search) {
            return $q->where('name', 'like', '%'. $search . '%');
        });

        return ShopResource::collection($query->orderBy($orderBy, $direction)->paginate($limit))
            ->response()
            ->getData(true);
    }

    public function getShopById(int $id)
    {
        $statusCode = 200;
        $details = null;
        $shop = null;

        try {
            $shop = Shop::where('status', Shop::STATUS_ACTIVE)->findOrFail($id);
            $clientSubscribe = \DB::table('clients_shops_subscriptions')
                ->where(['shop_id' => $id, 'client_id' => auth()->id()])->exists();
            $details['client_subscriptions'] = $clientSubscribe;
            $details['shopSaleCount'] = Product::where(['shop_id' => $id, 'is_sale' => 1])->count();
        } catch (ModelNotFoundException $e) {
            $shop = 'Shop Not Found';
            $statusCode = 404;
        }

        return ['shop' => $shop, 'details' => $details, 'statusCode' => $statusCode];
    }

}
