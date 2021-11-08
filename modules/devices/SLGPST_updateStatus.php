<?php
$device_id = $this->getProperty('deviceId');
$old_content = $this->getProperty('allproperties');
$content=getURL('http://livegpstracks.com/viewer_coos_s.php?code='.$device_id,  0); 
if (strval($old_content) != strval($content)) {
    $data=json_decode($content, true);
    //DebMes($content);
    $this->setProperty('coordinates', $data[0]['lat'].','.$data[0]['lng']);
    $this->setProperty('speed', $data[0]['speed']);
    $this->setProperty('allproperties', $content);
    //DebMes($this);

}
$this->setProperty('updated', time());
// Тут надо вызывать по таймеру этот метод
if (!$time_to_chek =  $this->getProperty('timeChek') ) $time_to_chek = 60;
SetTimeOut("Restart timer for traker GPS ".$this->object_title,"callMethod('".$this->object_title.".updateStatus');", $time_to_chek );
