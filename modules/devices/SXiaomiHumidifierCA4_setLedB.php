<?php
//DebMes($params['NEW_VALUE']);
include_once(ROOT . '/modules/devices/addons/SXIMIClass/miio.class.php');
$miio_debug = false;
$dev = new miIO($this->getProperty('deviceip'), '0.0.0.0', $this->getProperty('token'), $miio_debug);
$dev->msgSendRcv('set_properties', '[{"did":"led_brightnes","siid":5,"piid":2,"value":'.$params['NEW_VALUE'].'}]', time());