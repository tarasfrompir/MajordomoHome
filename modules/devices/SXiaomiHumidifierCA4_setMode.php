<?php
//DebMes($params['NEW_VALUE']);
include_once(ROOT . '/modules/devices/addons/SXIMIClass/miio.class.php');
$miio_debug = false;
$dev = new miIO($this->getProperty('deviceip'), '0.0.0.0', $this->getProperty('token'), $miio_debug);
$dev->msgSendRcv('set_properties', '[{"did":"mode","siid":2,"piid":5,"value":'.$params['NEW_VALUE'].'}]', time());
