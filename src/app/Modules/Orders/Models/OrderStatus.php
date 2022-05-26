<?php namespace App\Modules\Orders\Models;


use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_statuses';
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name',
        'description'
    ];
}
