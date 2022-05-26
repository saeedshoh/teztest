<?php namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Brand extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'description'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'brand_id', 'id');
    }

}
