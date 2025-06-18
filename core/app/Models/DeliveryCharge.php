<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'min_order',
        'delivery_charge',
        'weight_in_grams',
        'setting_type',
    ];


    public function zone()
    {
        return $this->belongsTo(ShippingZone::class, 'zone_id');
    }

}
