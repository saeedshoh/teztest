<?php namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    use SoftDeletes;

    protected $table = 'product_options';

    protected $fillable = [
        'product_id',
        'product_option_type_id',
        'product_option_value_id',
        'option_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productOptionType()
    {
        return $this->belongsTo(ProductOptionType::class);
    }

    public function productOptionValue()
    {
        return $this->belongsTo(ProductOptionValue::class);
    }
}
