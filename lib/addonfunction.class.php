<?php

function geocodingFromCoord($lat=0, $lon=0) {
    $out = getURL('https://nominatim.openstreetmap.org/reverse?lat='.$lat.'&lon='.$lon.'&format=json');
    $arr = json_decode($out, true);
    return $arr['display_name'];
}