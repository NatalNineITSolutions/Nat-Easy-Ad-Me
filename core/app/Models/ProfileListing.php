<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'occupation',
        'annual_income',
        'caste',
        'mother_tongue',
        'country',
        'state',
        'city',
        'image',
        'description',
        'paid',
        'payment_method',
        'is_verified',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
