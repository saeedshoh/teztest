<?php namespace App\Modules\Common\Models;


use App\Modules\Auth\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use SoftDeletes;

    protected $table = 'complaints';

    protected $fillable = [
        'subject',
        'message',
        'client_id',
        'email'
    ];

    public function complaintMedia()
    {
        return $this->hasMany(ComplaintMedia::class,'complaint_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'subscriber_id');
    }

}
