<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Extend this instead of Model
use Illuminate\Notifications\Notifiable;


class MatrimonyUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'matrimony_users'; // Ensure correct table name if different

    protected $fillable = ['name', 'email', 'password']; // Define fillable attributes

    protected $hidden = ['password']; // Hide password from JSON responses
}
