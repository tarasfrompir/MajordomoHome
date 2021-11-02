<?php

/**
 * Main project script
 *
 * @package MajorDoMo
 * @author Serge Dzheigalo <jey@tut.by> http://smartliving.ru/
 * @version 1.1
 */

include_once("./config.php");
include_once("./lib/loader.php");

// start calculation of execution time
startMeasure('TOTAL');

include_once(DIR_MODULES . "application.class.php");

$session = new session("prj");

const GPS_LOCATION_RANGE_DEFAULT = 500;

// connecting to database
$db = new mysql(DB_HOST, '', DB_USER, DB_PASSWORD, DB_NAME);

include_once("./load_settings.php");

if ($_REQUEST['location']) {
    $tmp = explode(',', $_REQUEST['location']);

    $_REQUEST['latitude'] = $tmp[0];
    $_REQUEST['longitude'] = $tmp[1];
}

/*if ($_REQUEST['op'] != '') {
    $op = $_REQUEST['op'];
    $ok = 0;

    if ($op == 'zones') {
        $zones = SQLSelect("SELECT * FROM gpslocations");
        echo json_encode(array('RESULT' => array('ZONES' => $zones, 'STATUS' => 'OK')));
        $ok = 1;
    }

    if ($op == 'add_zone' && $_REQUEST['latitude'] && $_REQUEST['longitude'] && $_REQUEST['title']) {
        global $title;
        global $range;

        $sqlQuery = "SELECT *
                     FROM gpslocations
                    WHERE TITLE LIKE '" . DBSafe($title) . "'";

        $old_location = SQLSelect($sqlQuery);

        if ($old_location['ID'])
            $title .= ' (1)';

        if (!$range)
            $range = 200;

        $rec = array();

        $rec['TITLE'] = $title;
        $rec['LAT'] = $_REQUEST['latitude'];
        $rec['LON'] = $_REQUEST['longitude'];
        $rec['RANGE'] = (int)$range;
        $rec['ID'] = SQLInsert('gpslocations', $rec);

        echo json_encode(array('RESULT' => array('STATUS' => 'OK')));

        $ok = 1;
    }

    if ($op == 'set_token' && $_REQUEST['token'] && $_REQUEST['deviceid']) {
        $sqlQuery = "SELECT *
                     FROM gpsdevices
                    WHERE DEVICEID = '" . DBSafe($_REQUEST['deviceid']) . "'";

        $device = SQLSelectOne($sqlQuery);

        if (!$device['ID']) {
            $device = array();

            $device['DEVICEID'] = $_REQUEST['deviceid'];
            $device['TITLE'] = 'New GPS Device';
            $device['ID'] = SQLInsert('gpsdevices', $device);
        }

        $device['TOKEN'] = $_REQUEST['token'];
        SQLUpdate('gpsdevices', $device);
        $ok = 1;
    }

    if (!$ok)
        echo json_encode(array('RESULT' => array('STATUS' => 'FAIL')));

    $db->Disconnect();
    exit;
}
*/
// Поддержка реализации Таскера
if ($_REQUEST['latitude']!='' && $_REQUEST['longitude']!='' && $_REQUEST['latitude']!='0' && $_REQUEST['longitude']!='0') {
    if ($_REQUEST['deviceid']) {
        if ($devices = getObjectsByProperty('deviceTId','==', $_REQUEST['deviceid'])) {
            sg($devices[0].'.allproperties', json_encode($_REQUEST));
        } else {
            Debmes('ВНИМАНИЕ!!! В системе обнаружено устройство , которое не добавлено в Простых устройствах по типу Смартфон использующий Tasker, id устройства - '. $_REQUEST['deviceid']);
        }
        
    }

}

if (!headers_sent()) {
    header("HTTP/1.0: 200 OK\n");
    header('Content-Type: text/html; charset=utf-8');
}

if (defined('BTRACED')) {
    echo "OK";
} elseif ($tmp['MESSAGE'] != '') {
    echo ' ' . $tmp['DAT'] . ' ' . transliterate($tmp['MESSAGE']);
}

// closing database connection
$db->Disconnect();

endMeasure('TOTAL'); // end calculation of execution time

/**
 * Calculate distance between two GPS coordinates
 * @param mixed $latA First coord latitude
 * @param mixed $lonA First coord longitude
 * @param mixed $latB Second coord latitude
 * @param mixed $lonB Second coord longitude
 * @return double
 */
function calculateTheDistance($latA, $lonA, $latB, $lonB)
{
    define('EARTH_RADIUS', 6372795);

    $lat1 = $latA * M_PI / 180;
    $lat2 = $latB * M_PI / 180;
    $long1 = $lonA * M_PI / 180;
    $long2 = $lonB * M_PI / 180;

    $cl1 = cos($lat1);
    $cl2 = cos($lat2);
    $sl1 = sin($lat1);
    $sl2 = sin($lat2);

    $delta = $long2 - $long1;
    $cdelta = cos($delta);
    $sdelta = sin($delta);

    $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
    $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

    $ad = atan2($y, $x);

    $dist = round($ad * EARTH_RADIUS);

    return $dist;
}
