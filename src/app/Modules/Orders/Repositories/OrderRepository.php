<?php namespace App\Modules\Orders\Repositories;


use App\Http\Resources\OrderResource;
use App\Modules\Common\Traits\CacheQuery;
use App\Modules\Shops\Models\Shop;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Modules\Common\Models\City;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderStatus;

class OrderRepository
{
    use CacheQuery;

    public function getAll(Request $request): LengthAwarePaginator
    {
        $orders = Order::with(['client', 'city', 'orderStatus', 'orderProduct', 'shop']);

        if ($request->id) {
            $orders->where('id', $request->id);
        }

        if ($request->city_id) {
            $orders->where('city_id', $request->city_id);
        }

        if ($request->delivery_agency_id) {
            $orders->where('delivery_agency_id', $request->delivery_agency_id);
        }

        if ($request->order_status_id) {
            $orders->where('order_status_id', $request->order_status_id);
        }

        if ($request->phone_number_delivery) {
            $orders->where('phone_number_delivery', 'like', "%$request->phone_number_delivery%");
        }

        if ($request->shop_id) {
            $orders->where('shop_id', $request->shop_id);
        }

        if ($request->client_fullname) {
            $orders->whereHas('client', function ($query) use ($request) {
                return $query->where('name', 'like', "%{$request->client_fullname}%");
            });
        }

        if ($request->address) {
            $orders->where('address', 'like', "%{$request->address}%");
        }

        if ($request->total_products_price) {
            $orders->where('total_products_price', $request->total_products_price);
        }

        if ($request->delivery_date) {
            $deliveryDate = Carbon::parse($request->delivery_date);
            $orders->whereDate('delivery_date', $deliveryDate);
        }

        if ($request->created_at) {
            $deliveryDate = Carbon::parse($request->created_at);
            $orders->whereDate('created_at', $deliveryDate);
        }

        if (auth()->user()->hasRole('merchant') && !auth()->user()->hasRole('admin')) {
            $orders->where('shop_id', auth()->user()->shop_id);
        }

        return $orders->latest()->paginate()->withQueryString();
    }

    public function getOrdersByClientId()
    {
        // \DB::enableQueryLog();
        $query = Order::with(['city', 'orderStatus', 'orderProduct', 'orderProduct.product', 'transaction', 'shop'])
            ->where('client_id', '=', auth()->id());


        $query->when(request('order_status_id', false), function ($q, $orderStatusIds) {
            return $q->whereIn('order_status_id', $orderStatusIds);
        });

        $query->when(request('shop_id', false), function ($q, $shopId) {
            return $q->whereIn('shop_id', $shopId);
        });

        $query->when(request('search', false), function ($q, $search) {
            return $q->whereHas('shop', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')->where('client_id', '=', auth()->id());
            })->orWhereHas('orderProduct', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')->where('client_id', '=', auth()->id());
            })->orWhere('id', 'like', $search . '%')->where('client_id', '=', auth()->id());
        });

        $fromDate = request('from_date', false);
        $toDate = request('to_date', false);
        $query->when($fromDate && $toDate, function ($q) use ($fromDate, $toDate) {
            $fromDate = $fromDate . " 00:00:00";
            $toDate = $toDate . " 23:59:59";
            $q->whereBetween('created_at', [$fromDate, $toDate]);
        });
        //$query->latest()->simplePaginate();
        //dd(\DB::getQueryLog());
        //  $query;
        return OrderResource::collection($query->latest()->simplePaginate())
            ->response()
            ->getData(true);

    }

    public function getOrderFilters(): array
    {
        $shopOrderClient = Order::select('shop_id')->distinct()
            ->where('client_id', auth()->id())->get()->pluck('shop_id');
        $query['filters'] = [
            'cities' => City::get()->pluck('name', 'id'),
            // 'deliveryAgencies' => DeliveryAgency::get()->pluck('name', 'id'),
            'orderStatuses' => OrderStatus::whereIn('id', [1, 2, 3, 4, 6, 7])->get()->pluck('name', 'id'),
            'shops' => Shop::where('status', 'ACTIVE')
                ->whereIn('id', $shopOrderClient)
                ->get()->pluck('name', 'id')
        ];

        return $query['filters'];
    }
}
