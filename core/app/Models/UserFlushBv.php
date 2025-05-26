<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFlushBv extends Model
{
    use HasFactory;

    protected $table = 'user_flush_bvs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'left_bv',
        'right_bv',
        'eligible_pairs',
    ];

    /**
     * Get the user that owns these flush BV records.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}