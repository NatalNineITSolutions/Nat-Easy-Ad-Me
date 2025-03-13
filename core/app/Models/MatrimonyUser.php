<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrimonyUser extends Model
{
    use HasFactory;

    protected $table = 'matrimony_users';

    protected $fillable = [
        'name', 'email', 'password', 'gender', 'dob', 'country', 'location', 'mobile'
    ];
}
