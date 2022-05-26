<?php namespace App\Http\Controllers\API\v0\Common;


use App\Http\Controllers\API\Controller;
use App\Modules\Common\Models\Complaint;
use App\Modules\Common\Models\ComplaintMedia;
use App\Modules\Common\Traits\UploadTrait;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    use UploadTrait;

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|min:3|max:191',
            'email' => 'required|email|min:3|max:191',
            'message' => 'required|string|min:3|max:500',
            'media.*' => 'mimes:jpg,jpeg,png,bmp|max:10000'
        ]);

        $files = $request->file('media');

        $complaint = Complaint::create([
            'subject' => $request->subject,
            'email' => $request->email,
            'message' => $request->message,
            'client_id' => auth()->id()
        ]);
        if($files) {
            foreach ($files as $file) {
                $fileName = $this->uploadOne($file, '/media/complaints' );

                ComplaintMedia::create([
                    'complaint_id' => $complaint->id,
                    'file_name' => $fileName
                ]);
            }
        }

        return $this->respond(null, 'Ваше обращение отправлено на рассмотрение.');
    }

}
