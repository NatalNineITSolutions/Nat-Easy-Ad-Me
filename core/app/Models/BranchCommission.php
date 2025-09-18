<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchCommission extends Model
{
    protected $fillable = [
        'branch_id',
        'order_id',
        'total_bv',
        'commission_percent',
        'commission_amount',
        'status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function order()
    {
        return $this->belongsTo(OrderDetail::class, 'order_id');
    }
}
