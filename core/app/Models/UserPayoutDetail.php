<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayoutDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payout_summary_id',
        'left_bv',
        'right_bv',
        'matching_pairs',
        'payout_amount',
        'tds_deduction',
        'service_charge',
        'net_amount',
        'status',
        'direct_business_income',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payoutSummary()
    {
        return $this->belongsTo(IncomePayoutManage::class, 'payout_summary_id');
    }

    // In User model
    public function payoutSettings()
    {
        return $this->hasOne(UserPayoutDetail::class);
    }
}
