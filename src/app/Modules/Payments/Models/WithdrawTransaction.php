<?php


namespace App\Modules\Payments\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class WithdrawTransaction extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'withdraw_transactions';
    protected $fillable = [
        'invoice_id',
        'invoice_response',
        'amount',
        'transaction_id',
        'transaction_response',
        'payment_response',
        'status',
        'credit_card',
        'type',
        'shop_id',
        'user_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
      'invoice_response' => 'array',
      'transaction_response' => 'array',
      'payment_response' => 'array'
    ];

}
