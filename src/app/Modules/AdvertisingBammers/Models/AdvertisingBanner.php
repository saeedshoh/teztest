<?php namespace App\Modules\AdvertisingBammers\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AdvertisingBanner extends Model
{
    use SoftDeletes;

    protected $table = "advertising_banners";

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'url',
        'status'
    ];


}
