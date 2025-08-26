<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\MediaUpload;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'branch_id',
        'name',
        'price',
        'distributor_price',
        'bv_points',
        'stock',
        'gst',
        'category_id',
        'unit_id',
        'unit_measurement',
        'description',
        'weight',
        'image',
        'size_id',
        'size_price',
        'size_stock',
        'is_active',
    ];


    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function imageFile()
    {
        return $this->belongsTo(MediaUpload::class, 'image');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function getSizeIdArrayAttribute(): array
    {
        return $this->size_id
            ? explode('|', $this->size_id)
            : [];
    }

    public function getSizePriceArrayAttribute(): array
    {
        return $this->size_price
            ? explode('|', $this->size_price)
            : [];
    }

    public function getSizeStockArrayAttribute(): array
    {
        return $this->size_stock
            ? explode('|', $this->size_stock)
            : [];
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)
            ->withPivot('price','stock')
            ->withTimestamps();
    }

    public function getVariantArrayAttribute(): array
    {
        $sizeIds  = $this->size_id_array;
        $prices   = $this->size_price_array;
        $stocks   = $this->size_stock_array;

        // Get size name map from DB (key = id, value = name)
        $sizeMap = \App\Models\Size::whereIn('id', $sizeIds)->pluck('name', 'id');

        $variants = [];

        foreach ($sizeIds as $index => $sizeId) {
            $variants[] = [
                'size'     => $sizeMap[$sizeId] ?? 'N/A',
                'price'    => isset($prices[$index]) ? (float) $prices[$index] : 0,
                'stock'    => isset($stocks[$index]) ? (int) $stocks[$index] : 0,
                'dp_price' => $this->distributor_price ?? 0,
            ];
        }

        return $variants;
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }


}
