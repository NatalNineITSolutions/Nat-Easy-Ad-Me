<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrimonyPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'partner_age',
        'mother_tongue',
        'religion',
        'caste',
        'height',
        'weight',
        'occupation',
        'location',
        'income',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
