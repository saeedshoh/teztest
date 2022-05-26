<?php namespace App\Modules\Orders\Models;


use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_products';
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'order_id',
        'product_id',
        'attributes',
        'product_tax',
        'comment',
    ];

    public function product()
    {
        return $this->belongsTo('App\Modules\Products\Models\Product')->withDefault(['id' => 0, 'name' => 'Удаленный товар.']);
    }

    public function order()
    {
        return $this->belongsTo('App\Modules\Orders\Models\Order');
    }

}
