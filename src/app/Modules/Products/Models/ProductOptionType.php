<?php namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOptionType extends Model
{
    use SoftDeletes;

    protected $table = 'product_option_types';

    protected $guarded = ['id'];

    protected $primaryKey = 'id';

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'name',
        'name_ru',
        'product_category_id'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
