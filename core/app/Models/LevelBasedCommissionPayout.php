<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelBasedCommissionPayout extends Model
{
    protected $table = 'level_based_commission_payouts';

    protected $fillable = [
        'user_id',
        'total_bv',
        'payment_type',
        'details',
        'payout_date',
        'tds_percent',
        'service_charge_percent',
        'payout_amount'
    ];

    protected $casts = [
        'details' => 'array',
        'payout_date' => 'datetime',
        'total_bv' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
