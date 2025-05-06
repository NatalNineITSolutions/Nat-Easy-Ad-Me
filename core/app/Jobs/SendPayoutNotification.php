<?php


namespace App\Jobs;

use App\Models\User;
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

    /** @var User */
    protected $user;

    /** @var float */
    protected $totalAmount;

    public function __construct(User $user, float $totalAmount)
    {
        $this->user        = $user;
        $this->totalAmount = $totalAmount;
    }

    public function handle()
    {
        // send one mail directly to $this->user->email
        Mail::to($this->user->email)
            ->queue(new PayoutProcessedMail(
                $this->user,
                $this->totalAmount
            ));
    }
}
