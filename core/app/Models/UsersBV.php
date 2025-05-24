<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Membership\app\Models\Membership;
use App\Models\UserFlush;


class UsersBV extends Model
{
    use HasFactory;

    protected $table = 'users_bvs';

    protected $fillable = [
        'user_id',
        'membership_id',
        'bv_points',
        'upgrade_time',
        'created_at',
        'type',
        'flushed_bv_ids',
        'consumed',
        'position'
    ];

    protected $casts = [
        'consumed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    // In UsersBv model
    public function flushes()
    {
        return $this->belongsToMany(UserFlush::class);
    }
}