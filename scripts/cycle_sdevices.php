<?php

chdir(dirname(__FILE__) . '/../');

include_once './config.php';
include_once './lib/loader.php';

set_time_limit(0);

include_once("./load_settings.php");

DebMes('start csd');

$checked_time = 0;

// обновление статуса устройств
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

// zigby
$zigbydevices = array();
//$aip =  getlocalip();
Define('XIAOMI_MULTICAST_PORT', 9898);
Define('XIAOMI_MULTICAST_PEER_PORT', 4321);
Define('XIAOMI_MULTICAST_ADDRESS', '224.0.0.50');
//Define('XIAOMI_MULTICAST_ADDRESS', '0.0.0.0');

if (($sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) === false) {
    DebMes("Failed to create socket");
    return;
}

socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);

if (!socket_bind($sock, XIAOMI_MULTICAST_ADDRESS, XIAOMI_MULTICAST_PORT)) {
    socket_close($sock);
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    DebMes(" Could not bind socket (Binding IP: 224.0.0.50) [$errorcode] $errormsg");
    exit;
}

socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 1, 'usec' => 0));
socket_set_option($sock, IPPROTO_IP, IP_MULTICAST_LOOP, true);
socket_set_option($sock, IPPROTO_IP, IP_MULTICAST_TTL, 32);
socket_set_option($sock, IPPROTO_IP, MCAST_JOIN_GROUP, array('group' => XIAOMI_MULTICAST_ADDRESS, 'interface' => 0, 'source' => 0));

// end zigby

while (1)
{
    // chek cycle
    if (time() - $checked_time > 30) {
        $checked_time = time();
        echo date("H:i:s") . " Cycle " . basename(__FILE__) . ' is running ';
    }
    
    // call methods for update stutus
    $i = 0;
    foreach ($Update_Status_objects as $object) {
        if ($checked_time - ($object['UPDATED'] + $object['TIMECHEK']*60-10) > 0) {
            raiseEvent($object['TITLE'].'.updateStatus');
            $Update_Status_objects[$i]['UPDATED'] = $checked_time;
            //DebMes('callmethod ' . $object['TITLE'].'.updateStatus');
        }
        $i = $i+1;
    }
    // end
    
    
    if (file_exists('./reboot') || IsSet($_GET['onetime'])) {
       socket_close($sock);
       exit;
    }
    
    usleep(10000);
    
    // get zigby info
    $buf = '';
   
    //DebMes('buf-'.$buf.'-');
    if ( @$r = socket_recvfrom($sock, $buf, 1024, 0, $remote_ip, $remote_port))  {
        $out = json_decode($buf, true);
        $data = json_decode($out['data'], true);
        
        // ignoring data
        // {"voltage":2995} dont need data ignore
        // {"ip":"192.168.1.94"} dont need data ignore
        if (count($data) == 1 and isset($data['voltage'])) {
            continue;
        } elseif (count($data) == 1 and isset($data['ip'])) {
            continue;
        }

        //DebMes('sid ' . serialize( $data));        
        ////$zigbydevices
        // motion - 'activity'//обязателен для бинарных сенсоров 
        // {"status":"motion"}
        if ($data["status"] == "motion") {
            if (!$zigbydevices[$out['sid']]) {
                if ($device = getObjectsByProperty('sid', '==', $out['sid'])) {
                    $zigbydevices[$out['sid']]['name'] = $device[0];                    
                } else {
                    DebMes('Founded zigby device with sid '. $out['sid'] . ' model-' . $out['model'] . ' data-' . $out['data']);
                    continue;
                }
            }
            sg($zigbydevices[$out['sid']]['name'].'.activity', 1, 0, 'cycle sdevice');
        // {"no_motion":"600"}
        } elseif (isset ($data["no_motion"])) {
            if (!$zigbydevices[$out['sid']]) {
                if ($device = getObjectsByProperty('sid', '==', $out['sid'])) {
                    $zigbydevices[$out['sid']]['name'] = $device[0];                    
                } else {
                    DebMes('Founded zigby device with sid '. $out['sid'] . ' model-' . $out['model'] . ' data-' . $out['data']);
                    continue;
                }
            }
            sg($zigbydevices[$out['sid']]['name'].'.activity', 0, 0, 'cycle sdevice');
        } elseif ($data["status"] == "close") {
        //{"voltage":3025,"status":"close"}
            if (!$zigbydevices[$out['sid']]) {
                if ($device = getObjectsByProperty('sid', '==', $out['sid'])) {
                    $zigbydevices[$out['sid']]['name'] = $device[0];                    
                } else {
                    DebMes('Founded zigby device with sid '. $out['sid'] . ' model-' . $out['model'] . ' data-' . $out['data']);
                    continue;
                }
            }
            sg($zigbydevices[$out['sid']]['name'].'.activity', 0, 0, 'cycle sdevice');
        } elseif ($data["status"] == "open") {
            //{"no_close":"300"}
            if (!$zigbydevices[$out['sid']]) {
                if ($device = getObjectsByProperty('sid', '==', $out['sid'])) {
                    $zigbydevices[$out['sid']]['name'] = $device[0];                    
                } else {
                    DebMes('Founded zigby device with sid '. $out['sid'] . ' model-' . $out['model'] . ' data-' . $out['data']);
                    continue;
                }
            }
            sg($zigbydevices[$out['sid']]['name'].'.activity', 1, 0, 'cycle sdevice');
        /*} elseif (isset ($data["no_close"])) {
            //{"no_close":"300"}
            if (!$zigbydevices[$out['sid']]) {
                if ($device = getObjectsByProperty('sid', '==', $out['sid'])) {
                    $zigbydevices[$out['sid']]['name'] = $device[0];                    
                } else {
                    DebMes('Founded zigby device with sid '. $out['sid'] . ' model-' . $out['model'] . ' data-' . $out['data']);
                    continue;
                }
            }
            //sg($zigbydevices[$out['sid']]['name'].'.activity', 1, 0, 'cycle sdevice');
        */
        } elseif (isset($data["alarm"]) and $data["alarm"]==1) {
            //"alarm":"1"
            if (!$zigbydevices[$out['sid']]) {
                if ($device = getObjectsByProperty('sid', '==', $out['sid'])) {
                    $zigbydevices[$out['sid']]['name'] = $device[0];                    
                } else {
                    DebMes('Founded zigby device with sid '. $out['sid'] . ' model-' . $out['model'] . ' data-' . $out['data']);
                    continue;
                }
            }
            sg($zigbydevices[$out['sid']]['name'].'.activity', 1, 0, 'cycle sdevice');
        } elseif (isset($data["alarm"]) and $data["alarm"]==0) {
            //"alarm":"0"
            if (!$zigbydevices[$out['sid']]) {
                if ($device = getObjectsByProperty('sid', '==', $out['sid'])) {
                    $zigbydevices[$out['sid']]['name'] = $device[0];                    
                } else {
                    DebMes('Founded zigby device with sid '. $out['sid'] . ' model-' . $out['model'] . ' data-' . $out['data']);
                    continue;
                }
            }
            sg($zigbydevices[$out['sid']]['name'].'.activity', 0, 0, 'cycle sdevice');
        } else {
            DebMes('Founded zigby device with sid '. $out['sid'] . ' model-' . $out['model'] . ' data-' . $out['data']);
        }
    }
    /// end
}

DebMes("Unexpected close of cycle: " . basename(__FILE__));
socket_close($sock);