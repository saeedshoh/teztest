<?php namespace App\Modules\Shops\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ShopCategory extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'shop_categories';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'parent_id',
        'tax'
    ];

    public function parent()
    {
        return $this->belongsTo(ShopCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ShopCategory::class, 'parent_id');
    }

    // recursive, loads all descendants
    public function subShopCategory()
    {
        return $this->children()->with('subShopCategory');
    }

}
