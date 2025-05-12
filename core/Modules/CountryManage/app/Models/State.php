<?php

namespace Modules\CountryManage\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\City;


class State extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['state', 'country_id', 'status', 'timezone'];
    protected $casts = ['status' => 'integer'];

    protected static function newFactory()
    {
        return \Modules\CountryManage\Database\factories\StateFactoryFactory::new();
    }

    public static function all_states()
    {
        return self::select(['id', 'state', 'country_id', 'status'])->where('status', 1)->get();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }


}
