<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\MediaUpload;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'distributor_price',
        'bv_points',
        'stock',
        'weight',
        'gst',
        'category_id',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function imageFile()
    {
        return $this->belongsTo(MediaUpload::class, 'image');
    }


}
