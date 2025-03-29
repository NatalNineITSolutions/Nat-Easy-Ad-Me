<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'profile_id',
        'status',
        'message'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function profile()
    {
        return $this->belongsTo(ProfileListing::class, 'profile_id');
    }
}
