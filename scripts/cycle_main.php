<?php

chdir(dirname(__FILE__) . '/../');

include_once("./config.php");
include_once("./lib/loader.php");

set_time_limit(0);

include_once("./load_settings.php");

setGlobal((str_replace('.php', '', basename(__FILE__))) . 'Run', time(), 1);
$cycleVarName = 'ThisComputer.' . str_replace('.php', '', basename(__FILE__)) . 'Run';

echo "Running startup maintenance" . PHP_EOL;
$run_from_start = 1;
include("./scripts/startup_maintenance.php");
$run_from_start = 0;

setGlobal('ThisComputer.started_time', time());
$started_time = time();
callMethod('ThisComputer.StartUp');
processSubscriptionsSafe('startup');

$sqlQuery = "SELECT *
               FROM classes
              WHERE TITLE = 'timer'";

$timerClass = SQLSelectOne($sqlQuery);
$o_qry = 1;

if ($timerClass['SUB_LIST'] != '') {
    $o_qry .= " AND (CLASS_ID IN (" . $timerClass['SUB_LIST'] . ")";
    $o_qry .= "  OR CLASS_ID = " . $timerClass['ID'] . ")";
} else {
    $o_qry .= " AND 0";
}

$old_minute = date('i');
$old_hour = date('h');
if (isset($_GET['onetime']) && $_GET['onetime']) {
    $old_minute = -1;
    if (date('i') == '00') {
        $old_hour = -1;
    }
}
$old_date = date('Y-m-d');

$checked_time = 0;
$Update_Status_objects = getObjectsByClass('SDevices');
$index = 0;
foreach ($Update_Status_objects as $object) {
    //DebMes(getGlobal($object['TITLE'].'.updated'));
    $Update_Status_objects[$index]['UPDATED'] = intval(getGlobal($object['TITLE'].'.updated'));
    $t = intval(getGlobal($object['TITLE'].'.timeChek'));
    if ($t < 1) $t=1;
    $Update_Status_objects[$index]['TIMECHEK'] = $t;
    $index = $index + 1;
}
//DebMes($Update_Status_objects);
/*
"ID": "1736",
"TITLE": "LiveGPSTraker01",
"CLASS_ID": "266",
"DESCRIPTION": "GPS Lanos",
"LOCATION_ID": "0",
"KEEP_HISTORY": "0",
"SYSTEM": "sdevice75",
"CLASS_TITLE": "SLGPST",
"LINKED_USER": "Lanos"
},
*/
while (1) {
    if (time() - $checked_time > 5) {
        $checked_time = time();
        echo date("H:i:s") . " Cycle " . basename(__FILE__) . ' is running ';

        $timestamp = time() - $started_time;
        //setGlobal('ThisComputer.uptime', $timestamp);

        $years = floor($timestamp / 31536000);
        $days = floor(($timestamp - ($years * 31536000)) / 86400);
        $hours = floor(($timestamp - ($years * 31536000 + $days * 86400)) / 3600);
        $minutes = floor(($timestamp - ($years * 31536000 + $days * 86400 + $hours * 3600)) / 60);
        $timestring = '';
        if ($years > 0) {
            $timestring .= $years . 'y ';
        }
        if ($days > 0) {
            $timestring .= $days . 'd ';
        }
        if ($hours > 0) {
            $timestring .= $hours . 'h ';
        }
        if ($minutes > 0) {
            $timestring .= $minutes . 'm ';
        }
        //setGlobal('ThisComputer.uptimeText', trim($timestring));

    }

    $m = date('i');
    $h = date('h');
    $dt = date('Y-m-d');

    #NewMinute
    if ($m != $old_minute) {
        processSubscriptionsSafe('MINUTELY');
        $sqlQuery = "SELECT ID, TITLE
                     FROM objects
                    WHERE $o_qry";

        $objects = SQLSelect($sqlQuery);
        $total = count($objects);

        for ($i = 0; $i < $total; $i++) {
            echo date('H:i:s') . ' ' . $objects[$i]['TITLE'] . "->onNewMinute\n";
            sg($objects[$i]['TITLE'] . '.time', date('Y-m-d H:i:s'));
            raiseEvent($objects[$i]['TITLE'] . '.onNewMinute');
        }
        $old_minute = $m;
        ///// call methods for update stutus
        $i = 0;
        foreach ($Update_Status_objects as $object) {
            if ($checked_time - $object['UPDATED'] + $object['TIMECHEK']*60 > 0) {
                setGlobal($object['TITLE'].'.updated', $checked_time);
                $Update_Status_objects[$i]['UPDATED'] = $checked_time;
                DebMes('set time updated for ' . $object['TITLE'].'.updated');
            }
            $i = $i+1;
        }
        /// end
    }

    #NewHour
    if ($h != $old_hour) {
        processSubscriptionsSafe('HOURLY');
        for ($i = 0; $i < $total; $i++) {
            echo date('H:i:s') . ' ' . $objects[$i]['TITLE'] . "->onNewHour\n";
            raiseEvent($objects[$i]['TITLE'] . '.onNewHour');
        }
        $old_hour = $h;
    }

    #NewDay
    if ($dt != $old_date) {
        processSubscriptionsSafe('DAILY');
        for ($i = 0; $i < $total; $i++) {
            echo date('H:i:s') . ' ' . $objects[$i]['TITLE'] . "->onNewDay\n";
            raiseEvent($objects[$i]['TITLE'] . '.onNewDay');
        }
        $old_date = $dt;
    }

    if (isRebootRequired() || IsSet($_GET['onetime'])) {
        exit;
    }

    sleep(1);
}

DebMes("Unexpected close of cycle: " . basename(__FILE__));
