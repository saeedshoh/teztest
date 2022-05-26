<?php namespace App\Modules\Products\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductMedia extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $table = 'product_media';

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['file_uri'];

    protected $fillable = [
        'file_name',
        'product_id',
        'media_type',
        'is_default',
        'position',
    ];

    public function getFileUriAttribute()
    {
        return config("image.uri.product_media") . 'images/small/' . $this->file_name;
    }
}
