<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayoutProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $totalAmount;

    public function __construct(User $user, float $totalAmount)
    {
        $this->user = $user;
        $this->totalAmount = $totalAmount;
    }

    public function build()
    {
        return $this
            ->subject('Your Payout Has Been Processed')
            ->markdown('mail.payout_processed')     
            ->with([
                'user' => $this->user,
                'totalAmount' => $this->totalAmount,
            ]);
    }
}
