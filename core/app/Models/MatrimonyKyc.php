<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Extend this instead of Model
use Illuminate\Notifications\Notifiable;


class MatrimonyKyc extends Authenticatable
{
    use Notifiable;

    protected $table = 'matrimony_kyc'; // Ensure correct table name if different

    protected $fillable = [
        'name', // Make name nullable
        'email', // Make email nullable
        'password', // Make password nullable
        'mobile', // Make mobile nullable
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
        'about_you',
        'image', // Add image if needed
        'matrimony_id', // Add matrimony_id if needed
    ];

    protected $hidden = ['password']; // Hide password from JSON responses
}
