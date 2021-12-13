<?php
include_once(ROOT . '/modules/devices/addons/SXIMIClass/miio.class.php');
$miio_debug = false;
$dev = new miIO($this->getProperty('deviceip'), '0.0.0.0', $this->getProperty('token'), $miio_debug);
$this->setProperty('updated', time());

if ($dev->msgSendRcv('get_properties', '[{"did":"temperature","siid":3,"piid":7,"value":0},{"did":"water_level","siid":2,"piid":7,"value":0},{"did":"humidity","siid":3,"piid":9,"value":0},{"did":"speed_level","siid":7,"piid":1,"value":0},{"did":"power","siid":2,"piid":1,"value":0},{"did":"mode","siid":2,"piid":5,"value":0},{"did":"led_brightnes","siid":5,"piid":2,"value":0},{"did":"clean_mode","siid":7,"piid":5,"value":0},{"did": "child_lock", "siid": 6, "piid": 1, "value": 0},{"did": "power_time", "siid": 7, "piid": 3, "value": 0},{"did": "target_humidity", "siid": 2, "piid": 6, "value": 50},{"did": "dry", "siid": 2, "piid": 8,  "code": 0, "value": 0},{"did": "use_time", "siid": 2, "piid": 9, "value": 5140816},{"did": "button_pressed", "siid": 2, "piid": 10, "value": 2},{"did": "buzzer", "siid": 4, "piid": 1, "value": 0},{"did": "actual_speed", "siid": 7, "piid": 1, "value": 0}]', time())) {
    $out = json_decode($dev->data, true);
	if (!$out['id']) {
	    DebMes('Результат выполнения команды не получен. Вероятно, указан неверный токен.');
	    $this->setProperty('alive', 0);
	} else {
	    $this->setProperty('allproperties', $dev->data);
	    $out=json_decode($dev->data, true);
	    foreach ($out['result'] as $value) {
            if ($value['did'] == 'power') $this->setProperty('state', intval($value['value']));
            if ($value['did'] == 'temperature' and $value['value'] > 65 ) say('Авария устройства ' . $this->object_description . ' ВОЗМОЖЕН ПОЖАР!!!',5);
	    }
	    $this->setProperty('alive', 1);
	} 
}
