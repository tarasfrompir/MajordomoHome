<?php

$this->device_types['Zigbysmoke'] = array(
    'TITLE'=>'Zigby smoke',
    'PARENT_CLASS'=>'SSensors',
    'CLASS'=>'SZigbysmoke',
    'DESCRIPTION' => 'Зигби устройство датчик дыма',
    'PROPERTIES'=>array(
        //'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства','KEEP_HISTORY'=>30, 'ONCHANGE'=>'updateDeviceData'),
        'activity'=>array('DESCRIPTION'=>'Состояние устройства 1-активно, 0-неактивно', 'KEEP_HISTORY'=>30, 'ONCHANGE'=>'updateDevice'), //обязателен для бинарных сенсоров 
        'sid'=>array('DESCRIPTION'=>'SID устройства','_CONFIG_TYPE'=>'text'), // обязателен для всех зигби устройств
        'Gateip'=>array('DESCRIPTION'=>'IP адрес шлюза к которому привязано устройство','_CONFIG_TYPE'=>'text'),
        //'temperature'=>array('DESCRIPTION'=>'Текущая температура устройства'),
        //'t'=>array('DESCRIPTION'=>'Время обновления статуса'),
        //'altitude'=>array('DESCRIPTION'=>'Высота'),
    ),
    'METHODS'=>array(
        'updateDevice'=>array('DESCRIPTION'=>'Обновление всех свойств устройства из свойства activity'),
        'updateStatus'=>array('DESCRIPTION'=>'Обновление статуса устройства','_CONFIG_SHOW'=>1),// обязателен для проверки обратной связи
        )
);
