<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use App\Modules\Common\Models\Complaint;
use Carbon\Carbon;

class ComplaintController extends Controller
{

    public function index()
    {
        $id = request('id');
        $subject = request('subject');
        $name = request('name');
        $phoneNumber = request('phone_number');
        $email = request('email');
        $createdAt = request('created_at');

        $complaints = Complaint::with(['client', 'complaintMedia']);

        if ($id){
            $complaints->where('id', $id);
        }

        if ($subject){
            $complaints->where('subject', 'like', "%$subject%");
        }

        if ($name){
            $complaints->whereHas('client', function ($query) use ($name){
                return $query->where('name', 'like', "%$name%");
            });
        }

        if ($phoneNumber){
            $complaints->whereHas('client', function ($query) use ($phoneNumber){
                return $query->where('phone_number',  $phoneNumber);
            });
        }

        if ($email){
            $complaints->where('email', 'like', "%$email%");
        }

        if ($createdAt) {
            $createdAt = Carbon::parse($createdAt);
            $complaints->whereDate('created_at', $createdAt);
        }

        return view('main.complaint', ['complaints' => $complaints->latest()->paginate()]);
    }

    public function show($id)
    {
        $complaint = Complaint::with(['client', 'complaintMedia'])->where('id',$id)->firstOrFail();
        return view('main.complaint_show', ['complaint' => $complaint]);
    }

}
