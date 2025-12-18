<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class BranchCodeGenerator
{
    public static function generate(): string
    {
        $prefix = 'BRN';
        $date   = now()->format('Ymd');

        $last = DB::table('branches')
            ->where('branch_code', 'like', "$prefix-$date%")
            ->orderBy('branch_code', 'desc')
            ->value('branch_code');

        $number = $last
            ? intval(substr($last, -4)) + 1
            : 1;

        return "$prefix-$date-" . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
