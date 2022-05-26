<?php namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProductCategory extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'product_categories';

   // protected $guarded = ['id'];

    protected $hidden = ['icon',  'deleted_at'];

    protected $appends = ['icon_uri'];

    protected $fillable = [
        'name',
        'icon',
        'parent_id'
    ];

    public function getIconUriAttribute(): ?string
    {
        return $this->icon ? config("image.uri.category_icon") . $this->icon : null;
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id')->whereHas('products');
    }

    public function childrenAdmin()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    // recursive, loads all descendants
    public function subCategory()
    {
        return $this->children()->with('subCategory')->withCount('products');
    }


    // recursive, loads all descendants
    public function subCategoryAdmin()
    {
        return $this->childrenAdmin()->with('subCategoryAdmin')->withCount('products');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
