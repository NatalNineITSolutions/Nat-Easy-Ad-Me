<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeRange extends Model
{
    use HasFactory;

    protected $fillable = ['from_income', 'to_income'];
}
