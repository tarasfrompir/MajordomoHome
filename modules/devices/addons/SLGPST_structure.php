<?php

$this->device_types['LiveGPSTraker'] = array(
    'TITLE'=>'LiveGPSTraker',
    'PARENT_CLASS'=>'SGPS',
    'CLASS'=>'SLGPST',
    'DESCRIPTION'=>'Устройства использующие модуль GPS с сайта http://livegpstracks.com/',
    'PROPERTIES'=>array(
        'deviceId'=>array('DESCRIPTION'=>'Код устройства','_CONFIG_TYPE'=>'text'),
        'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства'),
        //'d'=>array('DESCRIPTION'=>'Дата обновления статуса'),
        //'t'=>array('DESCRIPTION'=>'Время обновления статуса'),
        //'altitude'=>array('DESCRIPTION'=>'Высота'),
        //'battery'=>array('DESCRIPTION'=>'Батарея'),
        
    ),
    'METHODS'=>array(
        'updateStatus'=>array('DESCRIPTION'=>'Обновление статуса устройтва','_CONFIG_SHOW'=>1),// обязателен для проверки обратной связи
        )
);

