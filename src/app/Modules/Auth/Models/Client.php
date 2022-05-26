<?php namespace App\Modules\Auth\Models;


use App\Modules\Products\Models\Wishlist;
use App\Modules\Shops\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Client extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const STATUS_INACTIVE = 'INACTIVE';
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_TOKEN_DESTROYED = 'TOKEN_DESTROYED';
    public const STATUS_ARRAY = [
        self::STATUS_INACTIVE => ['id' => self::STATUS_INACTIVE, 'label' => 'inactive'],
        self::STATUS_ACTIVE => ['id' => self::STATUS_ACTIVE, 'label' => 'active'],
        self::STATUS_TOKEN_DESTROYED => ['id' => self::STATUS_TOKEN_DESTROYED, 'label' => 'token of client destroyed']
    ];

    protected $fillable = [
        'subscriber_id',
        'token',
        'phone_number',
        'status',
        'name',
        'is_agree_regulation'
    ];

    protected $primaryKey = 'subscriber_id';

    protected $table = 'clients';


    protected $hidden = ['deleted_at', 'status', 'token'];

    public function shopsSubscriptions()
    {
        return $this->belongsToMany(Shop::class, 'clients_shops_subscriptions');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

}
