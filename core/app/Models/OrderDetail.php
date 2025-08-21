<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;
use Modules\CountryManage\app\Models\City;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_quantity',
        'product_total_price',
        'total_delivery_charge',
        'grand_total',
        'name',
        'email',
        'phone_number',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'order_status',
        'is_paid',
        'transaction_id',
        'size',              
        'total_bv',  
    ];

    // Relationships (optional)
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

}
