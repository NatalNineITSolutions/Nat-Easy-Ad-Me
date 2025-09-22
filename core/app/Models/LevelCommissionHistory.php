<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelCommissionHistory extends Model
{
    protected $table = 'level_commission_histories';

    protected $fillable = [
        'order_id',
        'purchaser_id',
        'upline_id',
        'level',
        'percentage',
        'bv_added',
    ];

    public function purchaser()
    {
        return $this->belongsTo(User::class, 'purchaser_id');
    }

    public function upline()
    {
        return $this->belongsTo(User::class, 'upline_id');
    }

    public function order()
    {
        return $this->belongsTo(OrderDetail::class, 'order_id');
    }
}
