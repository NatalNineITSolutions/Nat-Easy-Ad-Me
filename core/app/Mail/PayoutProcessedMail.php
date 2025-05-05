<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserPayoutDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayoutProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $payoutDetail;

    public function __construct(User $user, UserPayoutDetail $payoutDetail)
    {
        $this->user = $user;
        $this->payoutDetail = $payoutDetail;
    }

    public function build()
    {
        return $this->subject('Your Payout Has Been Processed')
                    ->view('emails.payout_processed')
                    ->with([
                        'user' => $this->user,
                        'payout' => $this->payoutDetail
                    ]);
    }
}