<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size_code', 'slug'];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('price','stock')
            ->withTimestamps();
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

}
