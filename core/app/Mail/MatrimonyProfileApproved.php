<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatrimonyProfileApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $profile;

    public function __construct($profile)
    {
        $this->profile = $profile;
    }

    public function build()
    {
        return $this->subject('🎉 Your Matrimony Profile Has Been Approved')
                    ->view('emails.matrimony_profile_approved');
    }
}
