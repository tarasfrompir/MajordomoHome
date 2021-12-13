<?php
//DebMes($params['NEW_VALUE']);
include_once(ROOT . '/modules/devices/addons/SXIMIClass/miio.class.php');
$miio_debug = false;
$dev = new miIO($this->getProperty('deviceip'), '0.0.0.0', $this->getProperty('token'), $miio_debug);
$dev->msgSendRcv('set_properties', '[{"did": "target_humidity", "siid": 2, "piid": 6, "value":'.$params['NEW_VALUE'].'}]', time());

if ($dev->data == '') $info = 'Результат выполнения команды не получен. Вероятно, указан неверный токен.';
else $info = $dev->data;
