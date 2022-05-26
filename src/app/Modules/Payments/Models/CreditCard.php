<?php


namespace App\Modules\Payments\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditCard extends Model
{
    use SoftDeletes;

    protected $table = 'credit_cards';
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'card_id',
        'card_pan',
        'card_name',
        'card_exp',
        'card_type',
        'client_id',
        'add_card_response'
    ];

    public function order()
    {
        return $this->belongsTo('App\Modules\Auth\Models\Client', 'client_id');
    }

}
