<?php

namespace Modules\CountryManage\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'state_id',
        'district',
        'status',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
