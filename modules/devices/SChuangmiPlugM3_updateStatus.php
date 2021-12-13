<?php
include_once(ROOT . '/modules/devices/addons/SXIMIClass/miio.class.php');
$miio_debug = false;
$dev = new miIO($this->getProperty('deviceip'), '0.0.0.0', $this->getProperty('token'), $miio_debug);
$this->setProperty('updated', time());
if ($out = $dev->msgSendRcv('get_prop', '["power","temperature"]', time())) {
    $out = json_decode($dev->data, true);
	if (!$out['id']) {
	    DebMes('Результат выполнения команды не получен. Вероятно, указан неверный токен.');
	    $this->setProperty('alive', 0);
	} else {
	    if ($out['result'][0] == 'off') $this->setProperty('state',0);
	    if ($out['result'][0] == 'on') $this->setProperty('state',1);
	    $this->setProperty('allproperties',$dev->data);
	    if ($out['result'][1] > 65 ) say('Авария устройства ' . $this->object_description . ' ВОЗМОЖЕН ПОЖАР!!!',5);
	    $this->setProperty('alive', 1);
	} 
}
//08:47:31 0.74814000 get_prop ["power","temperature"]
// out {"result":["off",44],"id":1636613489}

