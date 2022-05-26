<?php namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOptionValue extends Model
{
    use SoftDeletes;

    protected $table = 'product_option_values';

    protected $fillable = [
        'name',
        'name_ru',
        'product_option_type_id'
    ];

    public function productOptionType()
    {
        return $this->belongsTo(ProductOptionType::class);
    }
}
