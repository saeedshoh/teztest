<?php namespace App\Modules\Orders\Models;


use App\Modules\Common\Models\City;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DeliveryAgency extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'delivery_agencies';
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name',
        'logo',
        'description',
        'phone_number',
        'status',
        'delivery_price',
        'user_id',
        'city_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
