<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantCardMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicants;

    /**
     * Create a new message instance.
     *
     * @param  \Illuminate\Support\Collection  $applicants
     * @return void
     */
    public function __construct($applicants)
    {
        $this->applicants = $applicants;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('प्रवेशपत्र बारेमा  जानकारी')
        ->view('Newupdategenerate.print')
        ->with('applicants', $this->applicants);
    }
}

