<?php namespace App\Modules\Shops\Models;


use App\Modules\Orders\Models\Order;
use App\Modules\Products\Models\Product;
use Cache;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Modules\Users\Models\User;
use App\Modules\Auth\Models\Client;
use App\Modules\Common\Models\City;


class Shop extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_INVISIBLE = 'INVISIBLE';

    public const STATUSES_ARRAY = [
        self::STATUS_ACTIVE => 'Активный',
        self::STATUS_INACTIVE => 'Заблокирован',
        self::STATUS_INVISIBLE => 'Скрытый'
    ];

    protected $table = 'shops';
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
    protected $appends = ['logoLink'];

    protected $fillable = [
        'name',
        'description',
        'logo',
        'phone_number',
        'shop_category_id',
        'address',
        'city_id',
        'status',
        'tin',
        'sin',
        'company_name',
        'company_type',
        'company_account_number',
        'bank_name',
        'bik',
        'bank_account_number',
        'delivery_price',
        'tezsum_site_id',
        'estimated_delivery_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'shop_id');
    }

    public function clientSubscriptions()
    {
        return $this->belongsToMany(Client::class, 'clients_shops_subscriptions', 'shop_id', 'client_id','id', 'subscriber_id');
    }

    public function clientShopsSubscriptions()
    {
        return $this->hasMany(ClientShopSubscription::class);
    }

    public function shopCategory()
    {
        return $this->belongsTo(ShopCategory::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function shopMedia()
    {
        return $this->hasMany(ShopMedia::class);
    }

    public function getLogoLinkAttribute()
    {
        $logo = $this->logo;
        return Cache::remember('shops:'.$this->id.':logo', 60, function () use ($logo) {
            return env('APP_URL') . '/media/shops/logo/' . $logo;
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productsWithSale()
    {
        return $this->hasMany(Product::class)->where('is_sale', 1);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
