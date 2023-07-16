<?php

function miniMaxSum($arr){
    # sum semua array menggunakan array_reduce
    $sum = array_reduce($arr, function($carry, $item){
        $carry += $item;
        return $carry;
    });

    # dapatkan min dan max didalam array
    $getMin = min($arr);
    $getMax = max($arr);

    # hasil sum dikurangi dengan min atau sebaliknya
    return sprintf("%d %d", $sum - $getMax, $sum - $getMin);
}

print_r(miniMaxSum([1,2,3,4,5]));