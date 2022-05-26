<?php


namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMetaCategory extends Model
{
    use SoftDeletes;

    protected $table = 'products_meta_categories';

    protected $fillable = [
        'name',
        'parent_id'
    ];

}
