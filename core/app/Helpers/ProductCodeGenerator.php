<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ProductCodeGenerator
{
    public static function generate(): string
    {
        $prefix = 'PRD';
        $date   = now()->format('Ymd');

        $last = DB::table('products')
            ->where('product_code', 'like', "$prefix-$date%")
            ->orderBy('product_code', 'desc')
            ->value('product_code');

        $number = $last
            ? intval(substr($last, -4)) + 1
            : 1;

        return "$prefix-$date-" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
