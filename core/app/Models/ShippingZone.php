<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;

class ShippingZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_name',
        'country_id',
        'state_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function deliveryCharges()
    {
        return $this->hasMany(DeliveryCharge::class, 'zone_id');
    }

}
