<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserPayoutDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PayoutProcessedMail;

class SendPayoutNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $payoutDetail;

    public function __construct(User $user, UserPayoutDetail $payoutDetail)
    {
        $this->user = $user;
        $this->payoutDetail = $payoutDetail;
    }

    public function handle()
    {
        Mail::to($this->user->email)
            ->queue(new PayoutProcessedMail($this->user, $this->payoutDetail));
    }
}