<?php


namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMeta extends Model
{
    use SoftDeletes;

    protected $table = 'products_meta';

    protected $fillable = [
        'name',
        'value',
        'category_meta_id',
        'product_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productMetaCategory()
    {
        return $this->belongsTo(ProductMetaCategory::class);
    }

}
