<?php namespace App\Modules\Common\Models;


use Illuminate\Database\Eloquent\Model;

class ComplaintMedia extends Model
{
    protected $table = 'complaint_media';

    protected $fillable = [
        'file_name',
        'complaint_id',
        'position'
    ];

}
