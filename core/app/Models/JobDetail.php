<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Backend\Listing;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;
use Modules\CountryManage\app\Models\City;

class JobDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'address',
        'profile_picture',
        'work_experience',
        'education',
        'skills',
        'certifications',
        'achievements',
        'projects',
        'summary',
        'portfolio_links',
        'availability_date',
        'work_preference',
        'expected_salary',
        'relocation_willingness',
        'work_authorization',
        'country_id',
        'state_id',
        'city_id',
        'category_id',
        'sub_category_id',
        'child_category_id',
        'listing_id',
        'image',
        'dob',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


}
