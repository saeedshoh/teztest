<?php namespace App\Modules\Products\Models;



use App\Modules\Orders\Models\OrderProduct;
use App\Modules\Shops\Models\Shop;
use App\Modules\Users\Models\User;
use App\Modules\Products\Services\ProductSearchRule;
use App\Modules\Products\Services\ProductIndexConfigurator;

use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model implements Auditable
{
    use Searchable;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'products';

    protected $indexConfigurator = ProductIndexConfigurator::class;
    protected $searchRules = [ProductSearchRule::class];

    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_DENIED = 'DENIED';
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_DRAFT = 'DRAFT';
    public const STATUS_INVISIBLE = 'INVISIBLE';

    public const STATUSES_ARRAY = [
      self::STATUS_ACTIVE => 'Активный',
      self::STATUS_INACTIVE => 'Заблокирован',
      self::STATUS_DENIED => 'Отказано',
      self::STATUS_PENDING => 'В ожидании',
      self::STATUS_DRAFT => 'Чернавик',
      self::STATUS_INVISIBLE => 'Скрыто'
    ];

    protected $fillable = [
        'title',
        'price',
        'product_category_id',
        'description',
        'brand_id',
        'status',
        'user_id',
        'shop_id',
        'quantity',
        'status',
        'sale',
        'is_sale',
        'sale_price_type',
        'rank',
        'view_count',
        'wishlist_count',
        'cart_add_count'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function productMedia()
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function productOptions()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'product_id', 'id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'brand_id' => $this->brand_id,
            'status' => $this->status,
            'shop_id' => $this->shop_id,
            'product_category_id' => $this->product_category_id,
            'rank' => $this->rank
        ];
    }

    public function searchableFields()
    {
        return ['title', 'description', 'rank'];
    }

    public function shouldBeSearchable()
    {
        return $this->status === 'ACTIVE';
    }

    protected $mapping = [
        'properties' => [
            'title' => [
                'type' => 'text',
                "analyzer" => "rebuilt_russian"
            ],
           'description' => [
               'type' => 'text',
               "analyzer" => "rebuilt_russian"
           ],
           'price' => [
               'type' => 'float'
           ],
           'rank' => [
               'type' => 'integer'
           ]
        ]
    ];

}
