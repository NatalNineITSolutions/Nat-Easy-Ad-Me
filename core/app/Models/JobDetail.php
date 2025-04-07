<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Backend\Listing;

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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function listing()
    // {
    //     return $this->hasOne(Listing::class, 'job_details_id', 'id');
    // }

}
