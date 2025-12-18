<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ListingCodeGenerator
{
    public static function generate(): string
    {
        $prefix = 'ADV'; // Advertisement
        $date   = now()->format('Ymd');

        $last = DB::table('listings')
            ->where('listing_code', 'like', "$prefix-$date%")
            ->orderBy('listing_code', 'desc')
            ->value('listing_code');

        $number = $last
            ? intval(substr($last, -4)) + 1
            : 1;

        return "$prefix-$date-" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
