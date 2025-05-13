<?php

namespace App\Models;

use App\Models\Backend\MediaUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Caste;
use App\Models\Religion;
use App\Models\ZodiacSign;
use App\Models\Star;
use App\Models\ProfileRequest;
use App\Models\MotherTongue;
use Modules\CountryManage\app\Models\City;
use Modules\CountryManage\app\Models\Country;

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
        'star',
        'date_of_birth',
        'religion',
        'gender',
        'visibility',
        'marital_status',
        'age',
        'address',
        'lon',
        'lat'
    ];

    public function imageAttachment()
    {
        return $this->belongsTo(MediaUpload::class, 'image');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

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

    public function country()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function zodiacSign()
    {
        return $this->belongsTo(ZodiacSign::class, 'zodiac_sign');
    }
    public function star()
    {
        return $this->belongsTo(Star::class, 'star');
    }

    public function motherTongue()
    {
        return $this->belongsTo(MotherTongue::class, 'mother_tongue');
    }

}
