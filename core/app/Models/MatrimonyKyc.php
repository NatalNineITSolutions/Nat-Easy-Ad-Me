<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Extend this instead of Model
use Illuminate\Notifications\Notifiable;


class MatrimonyKyc extends Authenticatable
{
    use Notifiable;

    protected $table = 'matrimony_kyc'; // Ensure correct table name if different

    protected $fillable = [
        'user_id',
        'marital_status',
        'dob',
        'family_status',
        'family_values',
        'family_type',
        'disability',
        'height',
        'weight',
        'caste',
        'dosham',
        'gothram',
        'education',
        'occupation',
        'annual_income',
        'employed_in',
        'country',
        'state',
        'city',
        'about',
        'image', 
        'matrimony_id',
        'document',
        'zodiac_sign',
        'star'
    ];

    protected $hidden = ['password']; // Hide password from JSON responses

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}