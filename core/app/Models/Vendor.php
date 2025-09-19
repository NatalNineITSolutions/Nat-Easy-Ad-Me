<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'primary_contact_name',
        'vendor_id',
        'branch_id',
        'company_name',
        'email',
        'phone',
        'website',
        'opening_balance',
        'currency',
        'billing_address',
        'shipping_address',
    ];

    /**
     * Casts for attributes.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'opening_balance' => 'decimal:2',
    ];
}
