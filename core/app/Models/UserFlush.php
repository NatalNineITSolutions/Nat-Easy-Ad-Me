<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserFlush extends Model
{
    use HasFactory;

    protected $table = 'users_flush';

    protected $fillable = [
        'user_id',
        'flushed_left_bv',
        'flushed_right_bv',
        'payout_summary_id',
    ];

    protected $casts = [
        'flushed_left_bv'  => 'decimal:2',
        'flushed_right_bv' => 'decimal:2',
    ];

    /**
     * Relationship: the user who owns this flush record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
