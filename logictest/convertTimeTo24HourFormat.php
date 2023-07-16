<?php

function convertTimeTo24HourFormat($time){
    # pisahkan bagiannya
    $parts = substr($time, -2);
    $timeParts = explode(":", $time);
    [$hour, $minute, $second, $period] = [intval($timeParts[0]), intval($timeParts[1]) ,intval($timeParts[2]), $parts];
    
    # konversi ke format 24 jam
    $hour = $hour <= 12 ? $period === "PM" ? $hour += 12 : ($period === "AM" && $hour === 12 ? 0 : $hour) : 00;

    # gabungkan kembali
    $time2format = sprintf("%02d:%02d:%02d", $hour, $minute, $second);
    return $time2format;

    
}

print_r(convertTimeTo24HourFormat("01:00:00AM"));