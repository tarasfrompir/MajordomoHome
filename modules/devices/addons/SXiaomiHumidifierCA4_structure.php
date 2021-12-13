<?php

$this->device_types['XiaomiHumidifierCA4'] = array(
    'TITLE'=>'Увлажнитель XiaomiHumidifier-CA4',
    'PARENT_CLASS'=>'SHumidifiers',
    'CLASS'=>'SXiaomiHumidifierCA4',
	'DESCRIPTION'=>'Увлажнитель XiaomiHumidifierCA4',
    'PROPERTIES'=>array(
        'state'=>array('DESCRIPTION'=>'Состояние устройства 1-on, 0-off', 'KEEP_HISTORY'=>7, 'ONCHANGE'=>'switch'),
        'token'=>array('DESCRIPTION'=>'Токен устройства','_CONFIG_TYPE'=>'text'),
        'deviceip'=>array('DESCRIPTION'=>'IP адрес устройства','_CONFIG_TYPE'=>'text'),
        'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'setRoomData'),
        'targetMode'=>array('DESCRIPTION'=>'Команда для изменения режима устройства', 'ONCHANGE'=>'setMode'),
        'targetHumidity'=>array('DESCRIPTION'=>'Команда для установки целевой влажности устройства', 'ONCHANGE'=>'setHumidity'),
        'targetLedB'=>array('DESCRIPTION'=>'Команда для установки режима подсветки устройства', 'ONCHANGE'=>'setLedB'),
        //'t'=>array('DESCRIPTION'=>'Время обновления статуса'),
        //'altitude'=>array('DESCRIPTION'=>'Высота'),
    ),
    'METHODS'=>array(
		'switch'=>array('DESCRIPTION'=>'Изменение состояния устройства(переключение)','_CONFIG_SHOW'=>1),
        'updateStatus'=>array('DESCRIPTION'=>'Обновление статуса устройтва','_CONFIG_SHOW'=>1),// обязателен для проверки обратной связи
        'setRoomData'=>array('DESCRIPTION'=>'Передача данных от устройства в комнату где оно находится'),
        'setHumidity'=>array('DESCRIPTION'=>'Установка целевой влажности'),
        'setMode'=>array('DESCRIPTION'=>'Установка режима'),
        'setLedB'=>array('DESCRIPTION'=>'Установка подсветки'),
        )
);
