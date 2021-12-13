<?php
//DebMes($params);
//DebMes($this->object_title);
// проверяем не запущен ли этот метод от обновления статуса устройства 
foreach ($params["m_c_s"] as $method_name) {
    $parts = explode(".", $method_name);
    if ($parts[1] == 'updateStatus') {
        //DebMes($this->object_title . ' Метод остановлен обновление статуса устройства ');
        return false; // если изменилось значение от статуса устройства то ничего не делаем а выходим из метода 
    }
}

include_once(ROOT . '/modules/devices/addons/SXIMIClass/miio.class.php');
$miio_debug = false;
$dev = new miIO($this->getProperty('deviceip'), '0.0.0.0', $this->getProperty('token'), $miio_debug);
$this->setProperty('updated', time());
if ($params["NEW_VALUE"] == 1 ) {
    if ($out = $dev->msgSendRcv('set_properties', '[{"did":"power","siid":2,"piid":1,"value":True}]', time())) {
        $out = json_decode($dev->data, true);
    	if (!$out['id']) {
    	    DebMes('Результат выполнения команды не получен. Вероятно, указан неверный токен.');
    	} 
    }
} else {
    if ($out = $dev->msgSendRcv('set_properties', '[{"did":"power","siid":2,"piid":1,"value":False}]', time())) {
        $out = json_decode($dev->data, true);
    	if (!$out['id']) {
    	    DebMes('Результат выполнения команды не получен. Вероятно, указан неверный токен.');
    	} 
    }
}

//"PROPERTY": "state",
//"NEW_VALUE": "0",
//"OLD_VALUE": "1",
//"SOURCE": "\/?md=application&action=ajaxsetglobal&var=ChuangmiPlugM301.state&value=0",
//"raiseEvent": "1",
//"m_c_s": [
//"ChuangmiPlugM301.updateStatus.d751713988987e9331980363e24189ce",
//"ChuangmiPlugM301.switch.e0cb46d980add985a55d861aebb33480"
//],
//"runSafeMethod": "1",
//"no_session": "1",
//"OBJECT_TITLE": "ChuangmiPlugM301"
//}