<?php namespace App\Modules\Shops\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ShopMedia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'shop_media';
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['file_uri'];

    protected $fillable = [
        'file_name',
        'title',
        'shop_id',
        'media_type',
        'is_default',
        'position',
    ];

    public function getFileUriAttribute()
    {
        return config("image.uri.shop_media") . 'files/' . $this->file_name;
    }


}
