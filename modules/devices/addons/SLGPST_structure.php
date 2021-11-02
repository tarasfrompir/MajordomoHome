<?php

$this->device_types['LiveGPSTraker'] = array(
    'TITLE'=>'LiveGPSTraker',
    'PARENT_CLASS'=>'SGPS',
    'CLASS'=>'SLGPST',
    'PROPERTIES'=>array(
        'timeChek'=>array('DESCRIPTION'=>'Период опроса устройства в секундах','_CONFIG_TYPE'=>'text'),
        'deviceId'=>array('DESCRIPTION'=>'Код устройства','_CONFIG_TYPE'=>'text'),
        'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства'),
        //'d'=>array('DESCRIPTION'=>'Дата обновления статуса'),
        //'t'=>array('DESCRIPTION'=>'Время обновления статуса'),
        //'altitude'=>array('DESCRIPTION'=>'Высота'),
        //'battery'=>array('DESCRIPTION'=>'Батарея'),
    ),
    'METHODS'=>array(
        'updateStatus'=>array('DESCRIPTION'=>'Обновление статуса трекера','_CONFIG_SHOW'=>1),
        )
);

