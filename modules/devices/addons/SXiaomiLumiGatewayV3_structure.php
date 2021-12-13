<?php

$this->device_types['XiaomiLumiGatewayV3'] = array(
    'TITLE'=>'Шлюз Xiaomi Lumi.Gateway.V3',
    'PARENT_CLASS'=>'SGateways',
    'CLASS'=>'SXiaomiLumiGatewayV3',
	'DESCRIPTION'=>'Шлюз Xiaomi Lumi.Gateway.V3',
    'PROPERTIES'=>array(
        //'state'=>array('DESCRIPTION'=>'Состояние устройства 1-on, 0-off', 'KEEP_HISTORY'=>7),
        'token'=>array('DESCRIPTION'=>'Токен устройства','_CONFIG_TYPE'=>'text'),
        'deviceip'=>array('DESCRIPTION'=>'IP адрес устройства','_CONFIG_TYPE'=>'text'),
        'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства','KEEP_HISTORY'=>30),
        //'temperature'=>array('DESCRIPTION'=>'Текущая температура устройства'),
        //'t'=>array('DESCRIPTION'=>'Время обновления статуса'),
        //'altitude'=>array('DESCRIPTION'=>'Высота'),
    ),
    'METHODS'=>array(
		//'switch'=>array('DESCRIPTION'=>'Изменение состояния устройства(переключение)','_CONFIG_SHOW'=>1),
        'updateStatus'=>array('DESCRIPTION'=>'Обновление статуса устройтва','_CONFIG_SHOW'=>1),// обязателен для проверки обратной связи
        //'setRoomData'=>array('DESCRIPTION'=>'Передача данных от устройства в комнату где оно находится'),
        )
);
