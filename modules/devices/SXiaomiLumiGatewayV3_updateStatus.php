<?php
include_once(ROOT . '/modules/devices/addons/SXIMIClass/miio.class.php');
$miio_debug = false;
$dev = new miIO($this->getProperty('deviceip'), '0.0.0.0', $this->getProperty('token'), $miio_debug);
$this->setProperty('updated', time());

if ($dev->msgSendRcv('get_arming', '[]', time())) {
    //DebMes($dev->data);
    $out = json_decode($dev->data, true);
	if (!$out['id']) {
	    DebMes('Результат выполнения команды не получен. Вероятно, указан неверный токен.');
	    $this->setProperty('alive', 0);
	} else {
	    $this->setProperty('allproperties', $dev->data);
	    $this->setProperty('alive', 1);
	} 
}

/*
22:20:49 0.59151600 get_arming []    22:26:08 0.42489200 {"result":["on"],"id":1637612768}
22:20:49 0.64033800 get_prop_fm []
22:20:49 0.70976700 get_lumi_dpf_aes_key []

22:20:49 0.80151300 get_channels {"start":0} {"result":{"chs":[{"id":527782008,"type":0,"url":"http:\/\/ximiraga.ru\/527782008.m3u8"},{"id":527782011,"type":0,"url":"http:\/\/ximiraga.ru\/527782011.m3u8"},{"id":527782024,"type":0,"url":"http:\/\/ximiraga.ru\/527782024.m3u8"},{"id":527782240,"type":0,"url":"http:\/\/vps2.ximiraga.ru\/527782058.m3u8"},{"id":527782344,"type":0,"url":"http:\/\/vps4.ximiraga.ru\/527782117.m3u8"},{"id":527782360,"type":0,"url":"http:\/\/vps1.ximiraga.ru\/527782095.m3u8"},{"id":527782459,"type":0,"url":"http:\/\/vps6.ximiraga.ru\/527782049.m3u8"},{"id":527782768,"type":0,"url":"http:\/\/vps1.ximiraga.ru\/527782035.m3u8"},{"id":527782769,"type":0,"url":"http:\/\/vps1.ximiraga.ru\/527782033.m3u8"},{"id":527782031,"type":0,"url":"http:\/\/vps2.ximiraga.ru\/527782019.m3u8"}]},"id":1637613364}

22:20:49 0.75663800 get_zigbee_channel [] {"result":[15],"id":1637613374}


*/
