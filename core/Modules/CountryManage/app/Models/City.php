<?php

namespace Modules\CountryManage\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;
use Modules\CountryManage\app\Models\District;

class City extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'city',
        'country_id',
        'state_id',
        'district_id',   
        'status'
    ];

    protected $casts = [
        'status' => 'integer'
    ];

    protected static function newFactory()
    {
        return \Modules\CountryManage\Database\factories\CityFactoryFactory::new();
    }

    public static function all_cities()
    {
        return self::select([
            'id',
            'city',
            'country_id',
            'state_id',
            'district_id', 
            'status'
        ])->where('status', 1)->get();
    }

    

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
