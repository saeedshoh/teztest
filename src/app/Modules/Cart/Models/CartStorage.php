<?php namespace App\Modules\Cart\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class CartStorage extends  Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'cart_storage';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'cart_data',
    ];

    public function setCartDataAttribute($value)
    {
        $this->attributes['cart_data'] = base64_encode(serialize($value));
    }

    public function getCartDataAttribute($value)
    {
        return unserialize(base64_decode($value));
    }

}
