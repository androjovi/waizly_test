<?php
function plusMinus($arr){
    $arrLength = count($arr);
    
    $positiveRatios = sprintf("%06f",count(array_filter($arr, function($list){
        return $list > 0;
    })) / $arrLength);

    $negativeRatios = sprintf("%06f",count(array_filter($arr, function($list){
        return $list < 0;
    })) / $arrLength);

    $zeroRatios = sprintf("%06f",count(array_filter($arr, function($list){
        return $list === 0;
    })) / $arrLength);

    return "$positiveRatios
$negativeRatios
$zeroRatios". PHP_EOL;
}

print_r(plusMinus([1,1,0,-1,-1]));