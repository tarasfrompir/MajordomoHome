<?php
set_time_limit(5);
$sid = $this->getProperty('sid');
Define('XIAOMI_MULTICAST_PORT', 9898);
Define('XIAOMI_MULTICAST_PEER_PORT', 4321);
Define('XIAOMI_MULTICAST_ADDRESS', '0.0.0.0');
if (($sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) === false) {
    DebMes("Failed to create socket");
    return;
}

socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);

if (!socket_bind($sock, XIAOMI_MULTICAST_ADDRESS, XIAOMI_MULTICAST_PORT)) {
    socket_close($sock);
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    DebMes(" Could not bind socket (Binding IP: 0.0.0.0) [$errorcode] $errormsg");
    return;
}

socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 5, 'usec' => 0));
socket_set_option($sock, IPPROTO_IP, IP_MULTICAST_LOOP, true);
socket_set_option($sock, IPPROTO_IP, IP_MULTICAST_TTL, 32);
socket_set_option($sock, IPPROTO_IP, MCAST_JOIN_GROUP, array('group' => XIAOMI_MULTICAST_ADDRESS, 'interface' => 0, 'source' => 0));
$message = '{"sid":"'.$sid.'","cmd":"read"}';
socket_sendto($sock, $message, strlen($message), 0, $this->getProperty('Gateip'), XIAOMI_MULTICAST_PORT);
@$r = socket_recvfrom($sock, $buf, 1024, 0, $remote_ip, $remote_port);

//DebMes('send commans');
//DebMes('buf - ' . $buf);
socket_close($sock);

if( $buf == '') {
    DebMes('Возможно указан неверный айпи адрес шлюза, или шлюз недоступен!!! Устройство - ' . $this->description );
    //$this->setProperty('alive',0);
} else {
    $out = json_decode($buf, true);
    //DebMes('Data ' . $out["data"]);
    if ($out["cmd"] == 'read_ack' and $out["sid"] == $sid) {
        //$this->setProperty('allproperties', $out["data"]);
        $data = json_decode($out["data"], true);
        if (isset ($data["voltage"])) {
            $this->setProperty('alive',1);
        }
        // /DebMes($data);
        if ($data['error'] == "No device") {
            $this->setProperty('alive',0);
            DebMes('no device');
        } elseif ($data["status"] == "open") {
            $this->setProperty('activity', 1);
        } elseif ($data["status"] == "close") {
            $this->setProperty('activity', 0);
        }
    }
}