<?php

$this->device_types['RadioRelayControlableBroadlink'] = array(
    'TITLE'=>'RadioRelayControlledBroadlink',
    'PARENT_CLASS'=>'SControllers',
    'CLASS'=>'SRadioRelayControlledBroadlink',
    'DESCRIPTION'=>'Устройства управляемые по радио или IR шлюзом Broadlink',
    'PROPERTIES'=>array(
        //'timeChek'=>array('DESCRIPTION'=>'Период опроса устройства в секундах','_CONFIG_TYPE'=>'text'),
        'ipContrDev'=>array('DESCRIPTION'=>'IP управляющего шлюза Broadlink','_CONFIG_TYPE'=>'text'),
        'codeOn'=>array('DESCRIPTION'=>'Код для включение устройства','_CONFIG_TYPE'=>'text'),
        'codeOff'=>array('DESCRIPTION'=>'Код для выключение устройства','_CONFIG_TYPE'=>'text'),
        //'allproperties'=>array('DESCRIPTION'=>'Все свойства устройства'),
        //'d'=>array('DESCRIPTION'=>'Дата обновления статуса'),
        //'t'=>array('DESCRIPTION'=>'Время обновления статуса'),
        //'altitude'=>array('DESCRIPTION'=>'Высота'),
        //'battery'=>array('DESCRIPTION'=>'Батарея'),
    ),
    'METHODS'=>array(
        //'updateStatus'=>array('DESCRIPTION'=>'Обновление статуса трекера','_CONFIG_SHOW'=>1),
        )
);

