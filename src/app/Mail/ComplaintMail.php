<?php

namespace App\Mail;

use App\Modules\Common\Models\Complaint;
//use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
//use Illuminate\Queue\SerializesModels;

class ComplaintMail extends Mailable
{
   // use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public Complaint $complaint;
    public function __construct(Complaint $complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('market@tcell.tj')
            ->view('email.complaint');
    }
}
