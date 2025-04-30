<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Caste;
use Modules\CountryManage\app\Models\City;

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
        'zodiac_sign',
        'star'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requests()
    {
        return $this->hasMany(ProfileRequest::class, 'profile_id');
    }

    public function caste()
    {
        return $this->belongsTo(Caste::class, 'caste');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function state()
    {
        return $this->belongsTo(City::class, 'state');
    }

    public function zodiacSign()
    {
        return $this->belongsTo(ZodiacSign::class, 'zodiac_sign');
    }
    public function star()
    {
        return $this->belongsTo(Star::class, 'star');
    }
    
}
