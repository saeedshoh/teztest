<?php namespace App\Modules\Orders\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'orders';
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'delivery_date' => 'date:Y-m-d'
    ];

    protected $fillable = [
        'client_id',
        'city_id',
        'order_status_id',
        'shop_id',
        'uniqid',
        'email',
        'phone_number_delivery',
        'address',
        'comment',
        'delivery_date',
        'is_shop_delivery',
        'delivery_price',
        'total_products_price'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo('App\Modules\Auth\Models\Client', 'client_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo('App\Modules\Common\Models\City','city_id');
    }

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo('App\Modules\Orders\Models\OrderStatus', 'order_status_id');
    }

    public function orderProduct(): HasMany
    {
        return $this->hasMany('App\Modules\Orders\Models\OrderProduct', 'order_id');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo('App\Modules\Shops\Models\Shop', 'shop_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne('App\Modules\Payments\Models\Transaction')->where('status', true);
    }

/*    public function deliveryAgency()
    {
        return $this->belongsTo('App\Modules\Orders\Models\DeliveryAgency', 'delivery_agency_id');
    }*/

}
