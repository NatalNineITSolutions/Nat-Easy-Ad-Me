<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchPayoutHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_payout_id',
        'branch_id',
        'total_commission',
        'status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function payout()
    {
        return $this->belongsTo(BranchPayout::class, 'branch_payout_id');
    }
}
