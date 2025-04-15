<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomePayoutManage extends Model
{
    protected $table = 'income_payout_manage';

    protected $fillable = [
        'payout_date',
        'previous_case_on_hand',
        'current_day_bv',
        'total_bv',
        'matching_pairs',
        'actual_pairs_paid',
        'pair_income',
        'total_output_amount',
        'balance_case_on_hand',
    ];

    protected $casts = [
        'payout_date' => 'date',
    ];
}
