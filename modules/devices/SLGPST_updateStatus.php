<?php
$this->setProperty('updated', time());
$device_id = $this->getProperty('deviceId');
$old_content = $this->getProperty('allproperties');
$content=getURL('http://livegpstracks.com/viewer_coos_s.php?code='.$device_id,  0); 
if (!$content) {
    $this->setProperty('alive', 0);
    return;
}
if (strval($old_content) != strval($content)) {
    $data=json_decode($content, true);
    //DebMes($content);
    $this->setProperty('coordinates', $data[0]['lat'].','.$data[0]['lng']);
    $this->setProperty('speed', $data[0]['speed']);
    $this->setProperty('allproperties', $content);
    //DebMes($this);

}
$this->setProperty('alive', 1);
