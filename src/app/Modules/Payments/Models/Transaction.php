<?php namespace App\Modules\Payments\Models;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $hidden = ['created_at', 'updated_at'];

    public const PAYMENT_TEZSUM = "1";
    public const PAYMENT_CREDIT_CARD = "33";

    public const PAYMENT_ARRAY = [
      self::PAYMENT_TEZSUM => 'Тезсум',
      self::PAYMENT_CREDIT_CARD => 'Корти милли'
    ];

    protected $fillable = [
        'amount',
        'order_id',
        'invoice_id',
        'transaction_id',
        'invoice_response',
        'transaction_response',
        'payment_response',
        'status',
        'desc',
        'commission'
    ];

    public function order()
    {
        return $this->belongsTo('App\Modules\Orders\Models\Order', 'order_id');
    }

}
