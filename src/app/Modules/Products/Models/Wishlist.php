<?php namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = "wishlists";

    public function client(){
        return $this->belongsTo(\App\Modules\Auth\Models\Client::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
