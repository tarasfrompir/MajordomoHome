<?php

function geocodingFromCoord($lat=0, $lon=0) {
    $out = getURL('https://nominatim.openstreetmap.org/reverse?lat='.$lat.'&lon='.$lon.'&format=json');
    $arr = json_decode($out, true);
    $adress = '';
    if ($arr['address']['city']) {
        $adress .=  $arr['address']['city'];
    }
    if ($arr['address']['borough']) {
        $adress .=', ' . $arr['address']['borough'];
    }
    if ($arr['address']['road']) {
        $adress .=', ' . $arr['address']['road'];
    }
    if ($arr['address']['house_number']) {
        $adress .= ', ' . $arr['address']['house_number'];
    }
    return $adress;
}

//22:38:01 0.31040600 Україна
//22:38:01 0.31020200 Київ
//22:38:01 0.30999500 Подільський район
//22:38:01 0.30978700 Поділ
//22:38:01 0.30957800 Плоське
//22:38:01 0.30936200 Волоська вулиця
//22:38:01 0.30909900 44
//$adress .= $arr['address']['city'].','.$arr['address']['road'].','.$arr['address']['house_number'];
